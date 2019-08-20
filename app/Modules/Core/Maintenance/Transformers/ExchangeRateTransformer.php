<?php

namespace Werp\Modules\Core\Maintenance\Transformers;

use Werp\Transformers\Transformer;

class ExchangeRateTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'               => $item['name'],
            'name'             => $item['name'],
            'currency_from_id' => $item['currency_from_id'],            
            'currency_to_id'   => $item['currency_to_id'],
            'value'            => $item['value'],
            'starting_at'      => $item['starting_at'],
            'active'           => $item['active'],
            'created_at'       => $item['created_at'],
            'updated_at'       => $item['updated_at'],
        ];
    }
}