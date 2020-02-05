<?php

namespace Werp\Modules\JMJ\ML\Transformers;

use Werp\Transformers\Transformer;

class CategoryTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'category_id'       => $item['category_id'],
            'active'            => $item['active'],
            'updated_at'        => $item['updated_at'],
            'created_at'        => $item['created_at']
        ];
    }
}
