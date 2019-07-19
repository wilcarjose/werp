<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Products\Models\Inout;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class InoutTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'code'              => $item['code'],
            'order_code'              => $item['order_code'],
            'amount' => $item['amount'],
            'tax_amount' => $item['tax_amount'],
            'discount_amount' => $item['discount_amount'],
            'total_amount' => $item['total_amount'],
            'currency' => $item['currency'],
            'description'       => $item['description'],
            'doctype_id'        => $item['doctype_id'],
            'warehouse_id'      => $item['warehouse_id'],
            'partner_id'      => $item['partner_id'],
            'date'              => $item['date'],
            'type'              => $item['type'],
            'state'             => $this->makeState($item),
            'created_at'        => $item['created_at']
        ];
    }

    protected function makeState($item)
    {
        $doc = $item['type'] === Inout::IN_TYPE ? Basedoc::IE_DOC : Basedoc::IO_DOC;
        $data = config('products.document.actions.'.$doc.'.'.$item['state']);

        return [
            'name' => trans($data['after_name']),
            'color' => $data['color'],
            'key' => $data['key'],
        ];
    }
}
