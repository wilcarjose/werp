<?php

namespace Werp\Modules\Core\Purchases\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Sales\Models\PriceListType;
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
        return $entity->purchases();
    }

    protected function makeUpdateData($id, $data)
    {
        $data['type'] = PriceListType::PURCHASE_TYPE;
        $data['currency_abbr'] = Currency::find($data['currency_id'])->abbr;

        return $data;
    }

    protected function makeCreateData($data)
    {
        $data['type'] = PriceListType::PURCHASE_TYPE;
        $data['currency_abbr'] = Currency::find($data['currency_id'])->abbr;

        return $data;
    }

    public function getOrCreatePriceList($currencyId, $type)
    {
        $priceList = PriceListType::where('currency_id', $currencyId)->where('type', $type)->active()->first();

        if ($priceList) {
            return $priceList;
        }
        
        $currency = Currency::find($currencyId);

        return PriceListType::create([
            'name' => 'Lista de precios en ' . $currency->name . ' (' . $type . ')',
            'currency_abbr' => $currency->abbr,
            'currency_id' => $currencyId,
            'type' => $type
        ]);
    }
}