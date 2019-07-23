<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class UomTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'description'       => $item['description'],
            'abbr'              => $item['abbr'],
            'symbol'            => $item['symbol'],
            'status'            => $item['status'],
            'created_at'        => $item['created_at'],
            'updated_at'        => $item['updated_at']
        ];
    }
}
