<?php

namespace Werp\Modules\Core\Purchases\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class InvoiceTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'number' => $item['number'],
            'control_number' => $item['control_number'],
            'order_code' => $item['order_code'],
            'date' => $item['date'],
            'description' => $item['description'],
            'alter_code' => $item['alter_code'],
            'reference' => $item['reference'],
            'total_price' => $item['total_price'],
            'total_tax' => $item['total_tax'],
            'total_discount' => $item['total_discount'],
            'total' => $item['total'],
            'currency_id' => $item['currency_id'],
            'type' => $item['type'],
            'partner_id' => $item['partner_id'],
            'doctype_id' => $item['doctype_id'],
            'price_list_type_id' => $item['price_list_type_id'],
            'order_id' => $item['order_id'],
            'tax_id' => $item['tax_id'],
            'discount_id' => $item['discount_id'],
            'payment_method_id' => $item['payment_method_id'],
            'state' => $this->makeState($item),
        ];
    }

    protected function makeState($item)
    {
        $doc = Basedoc::PI_DOC;
        $data = config('purchases.document.actions.'.$doc.'.'.$item['state']);

        return [
            'name' => trans($data['after_name']),
            'color' => $data['color'],
            'key' => $data['key'],
        ];
    }
}
