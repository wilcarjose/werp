<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Sales\Models\Price;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Sales\Models\PriceList;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;

class PriceListService extends BaseService
{
	protected $entity;

    public function __construct(
    	PriceList $entity,
        Price $entityDetail,
    	DoctypeService $doctypeService
    ) {
        $this->entity = $entity;
        $this->entityDetail = $entityDetail;
        $this->doctypeService = $doctypeService;
    }

    public function create(array $data)
    {

        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        if (isset($data['reference_price_list_type_id']) && $data['reference_price_list_type_id'] == 0) {
            unset($data['reference_price_list_type_id']);
        }

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
        $data['active'] = BaseModel::STATUS_INACTIVE;
        $data['price_list_type_id'] = $priceListType->id;
        
        return $data;
    }

    protected function makeUpdateData($id, $data)
    {
        $data['reference_price_list_type_id'] = isset($data['reference_price_list_type_id']) && $data['reference_price_list_type_id'] != 0 ?
            $data['reference_price_list_type_id'] :
            null;            
        
        return $data;
    }

    public function process($id)
    {
        $entity = $this->getById($id);
        $entity->state = Basedoc::PR_STATE;
        $entity->save();

        $entity->detail()->update(['active' => BaseModel::STATUS_ACTIVE]);
    }

    public function reverse($id)
    {
        $entity = $this->getById($id);
        $entity->state = Basedoc::PE_STATE;
        $entity->save();

        $entity->detail()->update(['active' => BaseModel::STATUS_INACTIVE]);
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

                // obtener la aperación y pasar como parámetro
                $total = $this->operationService->setOperation($operation)->calculate($price->price);

                $priceData = [
                    'price_list_type_id' => $entity->price_list_type_id,
                    'starting_at' => $entity->starting_at,
                    'currency' => $priceListType->currency,
                    'active' => BaseModel::STATUS_INACTIVE,
                    'price' => $total,
                    'product_id' => $price->product_id
                ];

                $entity->detail()->create($priceData);
            }
        }
    }
}
