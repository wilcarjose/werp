<?php

namespace Werp\Transformers;

class UsersTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                    => $item['id'],
            'fullname'              => $item['name'],
            'email'                 => $item['email'],
            'active'                => $item['active'],
            'created_at'            => $item['created_at']
        ];
    }
}
