<?php

namespace Werp\Modules\Core\Sales\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Sales\Models\Order;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class SaleOrderTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'code'              => $item['code'],
            'total_price'            => $item['total_price'],
            'total_tax'        => $item['total_tax'],
            'total_discount'   => $item['total_discount'],
            'total'      => $item['total'],
            'currency'          => $item['currency'],
            'doctype_id'        => $item['doctype_id'],
            'warehouse_id'      => $item['warehouse_id'],
            'partner_id'        => $item['partner_id'],
            'date'              => $item['date'],
            'type'              => $item['type'],
            'sale_channel_id'   => $item['sale_channel_id'],
            'price_list_type_id'=> $item['price_list_type_id'],
            'tax_id'            => $item['tax_id'],
            'discount_id'       => $item['discount_id'],
            'state'             => $this->makeState($item),
            'created_at'        => $item['created_at']
        ];
    }

    protected function makeState($item)
    {
        $doc = Basedoc::SO_DOC;
        $data = config('sales.document.actions.'.$doc.'.'.$item['state']);

        return [
            'name' => trans($data['after_name']),
            'color' => $data['color'],
            'key' => $data['key'],
        ];
    }
}
