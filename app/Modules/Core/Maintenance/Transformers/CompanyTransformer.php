<?php

namespace Werp\Modules\Core\Maintenance\Transformers;

use Werp\Transformers\Transformer;

class CompanyTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'            => $item['id'],
            'name'          => $item['name'],
            'description'   => $item['description'],            
            'document'      => $item['document'],
            'document2'     => $item['document2'],
            'phone1'        => $item['phone1'],
            'phone2'        => $item['phone2'],
            'phone3'        => $item['phone3'],
            'email'         => $item['email'],
            'created_at'    => $item['created_at'],
            'updated_at'    => $item['updated_at'],
        ];
    }
}