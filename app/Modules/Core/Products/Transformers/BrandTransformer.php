<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class BrandTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'description'       => $item['description'],
            'country'           => $item['country'],
            'status'            => $item['status'],
            'created_at'        => $item['created_at']
        ];
    }
}
