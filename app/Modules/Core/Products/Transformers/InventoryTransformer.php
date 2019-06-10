<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class InventoryTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'code'              => $item['code'],
            'description'       => $item['description'],
            'doctype_id'        => $item['doctype_id'],
            'warehouse_id'      => $item['warehouse_id'],
            'date'              => $item['date'],
            'created_at'        => $item['created_at']
        ];
    }
}
