<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class WarehouseTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'abbr'              => $item['abbr'],
            'color'              => $item['color'],
            'active'            => $item['active'],
            'created_at'        => $item['created_at']
        ];
    }
}
