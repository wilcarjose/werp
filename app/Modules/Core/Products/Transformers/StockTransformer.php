<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class StockTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'code'        => $item['product']->code,
            'name'        => $item['product']->name,
            'category'    => $item['product']->category ? $item['product']->category->name : '',
            'warehouse'   => $item['warehouse']->name,
            'qty'         => $item['qty'],
        ];
    }
}
