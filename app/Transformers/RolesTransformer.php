<?php

namespace Werp\Transformers;

class RolesTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'    => $item['id'],
            'name'  => $item['name'],
            'label' => $item['label']
        ];
    }
}
