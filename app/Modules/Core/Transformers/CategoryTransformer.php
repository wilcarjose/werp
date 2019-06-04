<?php

namespace Werp\Modules\Core\Transformers;

use Werp\Transformers\Transformer;

class CategoryTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'status'            => $item['status'],
            'created_at'        => $item['created_at']
        ];
    }
}
