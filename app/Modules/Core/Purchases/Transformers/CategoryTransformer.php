<?php

namespace Werp\Modules\Core\Purchases\Transformers;

use Werp\Transformers\Transformer;

class CategoryTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'category_id'       => $item['category_id'],
            'status'            => $item['status'],
            'updated_at'        => $item['updated_at'],
            'created_at'        => $item['created_at']
        ];
    }
}
