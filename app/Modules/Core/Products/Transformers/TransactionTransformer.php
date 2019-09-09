<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class TransactionTransformer extends Transformer
{
    public function transform($item)
    {
        $reference = [
            'text' => '',
            'url'  => ''
        ];

        $reference = get_process_url($item['type'], $item['process_id'], $item['reference']);

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
