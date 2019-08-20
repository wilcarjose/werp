<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Currency;
use Werp\Modules\Core\Maintenance\Models\ExchangeRate;


class ExchangeRateService extends BaseService
{
	protected $entity;
	protected $currency;

    public function __construct(ExchangeRate $entity, Currency $currency)
    {
        $this->entity = $entity;
        $this->currency = $currency;
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
    	$currencyFrom = $this->currency->find($data['currency_from_id']);
    	$currencyTo = $this->currency->find($data['currency_to_id']);

        $data['name'] = $currencyFrom->abbr .'/'.$currencyTo->abbr;
        $date['starting_at'] = date('Y-m-d H:i:s');

        $exchange = $this->entity->active()
        	->where('name', $data['name'])
            //->where('starting_at', '<', date('Y-m-d H:i:s'))
            ->orderBy('starting_at', 'desc')
            ->first();

        return $this->entity->create($data);
    }

    public function update($id, $data)
    {
        $currencyFrom = $this->currency->find($data['currency_from_id']);
    	$currencyTo = $this->currency->find($data['currency_to_id']);

        $data['name'] = $currencyFrom->abbr .'/'.$currencyTo->abbr;
        $date['starting_at'] = date('Y-m-d H:i:s');

        return $this->entity->create($data);
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