<?php

namespace Werp\Modules\Core\Purchases\Transformers;

use Werp\Transformers\Transformer;

class PriceListTypeTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'description'       => $item['description'],
            'currency'          => $item['currency'],
            'type'              => $item['type'],
            'active'            => $item['active'],
            //'created_at'        => $item['created_at']
        ];
    }
}
