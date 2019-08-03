<?php

namespace Werp\Modules\Core\Maintenance\Transformers;

use Werp\Transformers\Transformer;

class AmountOperationTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'            => $item['id'],
            'name'          => $item['name'],
            'description'   => $item['description'],            
            'operation'     => $item['operation'],
            'reference'     => $item['reference'],
            'round'         => $item['round'],
            'active'        => $item['active'],
            'created_at'    => $item['created_at'],
            'updated_at'    => $item['updated_at'],
        ];
    }
}