<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class PriceTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'currency'          => $item['currency'],
            'description'       => $item['description'],
            'status'            => $item['status'],
            'created_at'        => $item['created_at']
        ];
    }
}
