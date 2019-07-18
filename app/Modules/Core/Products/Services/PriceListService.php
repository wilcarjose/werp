<?php

namespace Werp\Modules\Core\Products\Services;

use Money\Money;
use Money\Currency;
use Werp\Services\BaseService;
use Werp\Modules\Core\Products\Models\PriceList;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;

class PriceListService extends BaseService
{
	protected $entity;

    public function __construct(
    	PriceList $entity,
    	DoctypeService $doctypeService
    ) {
        $this->entity = $entity;
        $this->doctypeService = $doctypeService;
    }

    public function create(array $data)
    {

        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        if (isset($data['reference_price_list_type_id']) && $data['reference_price_list_type_id'] == 0) {
            unset($data['reference_price_list_type_id']);
        }

        $data['reference'] = (float)$data['reference'];
        //$reference = new Money($reference, new Currency('USD'));
        //dd($reference->getAmount());
        $entity = $this->entity->create($data);

        $this->generatePrices($entity);

        return $entity;
    }

    public function update($id, $data)
    {
        $entity = $this->entity->find($id);

        if (!$entity) {
            return false;
        }

        $data = $this->makeUpdateData($id, $data);

        $entity->update($data);

        $this->generatePrices($entity);

        return $entity;
    }

    protected function makeData($data, $entity = null)
    {
        $priceListType = $entity->priceListType;

        $data['starting_at'] = $entity->starting_at;
        $data['currency'] = $priceListType->currency;
        $data['status'] = 'inactive';
        $data['price_list_type_id'] = $priceListType->id;
        
        return $data;
    }

    protected function makeUpdateData($id, $data)
    {
        $data['reference_price_list_type_id'] = isset($data['reference_price_list_type_id']) && $data['reference_price_list_type_id'] != 0 ?
            $data['reference_price_list_type_id'] :
            null;

        $data['reference'] = isset($data['reference']) ?
            $data['reference'] :
            null;

        $data['operation'] = isset($data['operation']) ?
            $data['operation'] :
            null;

        $data['round'] = isset($data['round']) ?
            $data['round'] :
            null;
            
        
        return $data;
    }

    public function process($id)
    {
        $entity = $this->getById($id);
        $entity->state = Basedoc::PR_STATE;
        $entity->save();

        $entity->detail()->update(['status' => 'active']);
    }

    public function reverse($id)
    {
        $entity = $this->getById($id);
        $entity->state = Basedoc::PE_STATE;
        $entity->save();

        $entity->detail()->update(['status' => 'inactive']);
    }

    public function generatePrices($entity)
    {
        $priceListType = $entity->priceListType;
        $referencePriceListType = $entity->referencePriceListType;

        if ($referencePriceListType) {
            $prices = $referencePriceListType->prices;

            if ($entity->detail()->count() > 0) {
                $entity->detail()->delete();
            }

            foreach($prices as $price) {

                $amount = 0.0000; //new Money(0, new Currency($priceListType->currency));

                if ($entity->operation == 'multiply') {
                    //$amount = $price->getPrice()->multiply($entity->reference);
                    $amount = $price->price * $entity->reference;
                }

                //$value = new Money($entity->reference * 100, new Currency($priceListType->currency));
                
                if ($entity->operation == 'add_amount') {
                    //$amount = $price->getPrice()->add($value);
                    $amount = $price->price + $entity->reference;
                }

                if ($entity->operation == 'sub_amount') {
                    //$amount = $price->getPrice()->subtract($value);
                    $amount = $price->price - $entity->reference;
                }

                if ($entity->operation == 'add_percent') {
                    //$value = $price->getPrice()->multiply($entity->reference)->divide(100);
                    //$amount = $price->getPrice()->add($value);
                    $value = $price->price * $entity->reference / 100;
                    $amount = $price->price + $value;
                }

                if ($entity->operation == 'sub_percent') {
                    //$value = $price->getPrice()->multiply($entity->reference)->divide(100);
                    //$amount = $price->getPrice()->subtract($value);
                    $value = $price->price * $entity->reference / 100;
                    $amount = $price->price - $value;
                }
    
                //$total = round($amount->getAmount(), (-1 * (int)$entity->round), PHP_ROUND_HALF_UP);
                $total = round($amount, $entity->round, PHP_ROUND_HALF_UP);

                $priceData = [
                    'price_list_type_id' => $entity->price_list_type_id,
                    'starting_at' => $entity->starting_at,
                    'currency' => $priceListType->currency,
                    'status' => 'inactive',
                    'price' => $total,
                    'product_id' => $price->product_id
                ];

                $entity->detail()->create($priceData);
            }
        }
    }
}
