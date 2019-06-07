<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class ProductTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'description'       => $item['description'],
            'category_id'       => $item['category_id'],
            'status'            => $item['status'],
            'created_at'        => $item['created_at']
        ];
    }
}
