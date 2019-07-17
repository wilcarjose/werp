<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class TransactionTransformer extends Transformer
{
    public function transform($item)
    {
        $reference = [
            'text' => $item['reference'],
            'url' => route('admin.products.inventories.edit', $item['reference']),
        ];

        return [
            'code'        => $item['product']->code,
            'name'        => $item['product']->name,
            //'category'    => $item['product']->category ? $item['product']->category->name : '',
            'warehouse'   => $item['warehouse']->name,
            'qty'         => $item['qty'],
            'date'        => $item['date'],
            'reference'   => $reference,
            'type'        => trans(config('werp.doctypes.'.$item['type'])),
        ];
    }
}
