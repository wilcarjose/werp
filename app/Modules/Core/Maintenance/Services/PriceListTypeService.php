<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\PriceListType;
use Werp\Modules\Core\Maintenance\Models\Currency;

class PriceListTypeService extends BaseService
{
	protected $entity;

    public function __construct(
    	PriceListType $entity
    ) {
        $this->entity = $entity;
    }

    protected function filters($entity)
    {
        //return $entity->sales();
        return $entity;
    }

    protected function makeUpdateData($id, $data)
    {
        $data['type'] = PriceListType::SALE_TYPE;
        $data['currency_abbr'] = Currency::find($data['currency_id'])->abbr;

        return $data;
    }

    protected function makeCreateData($data)
    {
        $data['type'] = PriceListType::SALE_TYPE;
        $data['currency_abbr'] = Currency::find($data['currency_id'])->abbr;

        return $data;
    }

    public function getOrCreatePriceList($currencyId, $type = 'sales')
    {
        if ($priceList = $this->getPriceListByCurrency($currencyId, $type)) {
            return $priceList;
        }
        
        $currency = Currency::find($currencyId);

        $typeName = trans('view.menu.' . $type);

        return PriceListType::create([
            'name' => 'Lista de ' . $typeName . ' en ' . $currency->name,
            'currency_abbr' => $currency->abbr,
            'currency_id' => $currencyId,
            'type' => $type
        ]);
    }

    public function getPriceListByCurrency($currencyId, $type = 'sales')
    {
        return PriceListType::where('currency_id', $currencyId)->where('type', $type)->active()->first();        
    }
}
