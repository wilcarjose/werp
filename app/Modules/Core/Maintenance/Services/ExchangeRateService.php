<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Currency;
use Werp\Modules\Core\Maintenance\Models\ExchangeRate;
use Werp\Modules\Core\Sales\Services\PriceListService;
use Werp\Modules\Core\Maintenance\Services\AmountOperationService;

class ExchangeRateService extends BaseService
{
	protected $entity;
	protected $currency;
    protected $operationService;
    protected $priceListService;

    public function __construct(
        Currency $currency,
        ExchangeRate $entity,
        PriceListService $priceListService,
        AmountOperationService $operationService
    ) {
        $this->entity = $entity;
        $this->currency = $currency;
        $this->operationService = $operationService;
        $this->priceListService = $priceListService;
    }

    public function getResults($sort, $order, $search, $paginate)
    {
        $entities = $this->entity->select('name', 'active')->groupBy('name', 'active');

        $total = $entities->count();

        if ($total <= 0) {
            return [[], []];
        }

        $entities = $paginate == 'off' ? $entities : $entities->paginate(10);

        $paginator = $paginate == 'off' ? [
                'total_count'  => $total,
                'total_pages'  => 1,
                'current_page' => 1,
                'limit'        => $total
            ] : [
                'total_count'  => $entities->total(),
                'total_pages'  => $entities->lastPage(),
                'current_page' => $entities->currentPage(),
                'limit'        => $entities->perPage()
            ];

        $data = $paginate == 'off' ? $entities->get()->toArray() : $entities->all();

        return [$data, $paginator];
    }

    public function create(array $data)
    {
        try {

            $this->begin();

        	$currencyFrom = $this->currency->find($data['currency_from_id']);
        	$currencyTo = $this->currency->find($data['currency_to_id']);

            $data['name'] = $currencyFrom->abbr .'/'.$currencyTo->abbr;
            $data['starting_at'] = date('Y-m-d H:i:s');

            $exchange = $this->entity->create($data);

            $this->updateOperation($exchange);

            $this->commit();

            if (isset($data['generate_price_list']) && $data['generate_price_list'] == 'on') {
                $this->priceListService->generateFromExchange($exchange);
            }

            return $exchange;

        } catch (Exception $e) {

            $this->rollback();

            throw new \Exception($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine());
        }
    }

    public function update($id, $data)
    {
        return $this->create($data);
    }

    protected function updateOperation($exchange)
    {
        $operation = $this->operationService->getByName($exchange->name);

        if ($operation) {
            $operation->description = 'Generada automáticamente desde tasas de cambio el '. $exchange->starting_at . ' (No cambiar el nombre)';
            $operation->value = $exchange->value;
            return $operation->save();
        }

        return $this->operationService->create([
            'name' => $exchange->name,
            'description' => 'Generada automáticamente desde tasas de cambio el '. $exchange->starting_at . ' (No cambiar el nombre)',
            'operation' => 'multiply',
            'value' => $exchange->value,
            'round' => '2',
        ]);
    }

    public function getByName($name)
    {
        return $this->entity->where('name', $name)->orderBy('starting_at', 'desc')->first();
    }

    public function exchangePrice($entity, $price)
    {
    	return $entity->value * $price;
    }
}