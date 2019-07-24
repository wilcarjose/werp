<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class TransactionTransformer extends Transformer
{
    public function transform($item)
    {
        $reference = [
            'text' => '',
            'url'  => ''
        ];

        if ($item['type'] == Basedoc::IN_DOC) {
            $reference = [
                'text' => $item['reference'],
                'url' => route('admin.products.inventories.edit', $item['reference']),
            ];
        }

        if ($item['type'] == Basedoc::IE_DOC) {
            $reference = [
                'text' => $item['reference'],
                'url' => route('admin.products.product_entry.edit', $item['reference']),
            ];
        }

        if ($item['type'] == Basedoc::IO_DOC) {
            $reference = [
                'text' => $item['reference'],
                'url' => route('admin.products.product_output.edit', $item['reference']),
            ];
        }

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
