<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

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
            'state'             => $this->makeState($item),
            'created_at'        => $item['created_at']
        ];
    }

    protected function makeState($item)
    {
        $data = config('products.document.actions.'.Basedoc::IN_DOC.'.'.$item['state']);

        return [
            'name' => trans($data['after_name']),
            'color' => $data['color'],
            'key' => $data['key'],
        ];
    }
}
