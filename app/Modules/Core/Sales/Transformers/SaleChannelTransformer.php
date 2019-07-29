<?php

namespace Werp\Modules\Core\Sales\Transformers;

use Werp\Transformers\Transformer;

class SaleChannelTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'name'              => $item['name'],
            'description'       => $item['description'],
            'status'            => $item['status'],
            'payment_method_id' => $item['payment_method_id'],
            'updated_at' 		=> $item['updated_at'],
            'created_at'        => $item['created_at'],
        ];
    }
}
