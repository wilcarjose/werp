<?php

namespace Werp\Modules\Core\Purchases\Transformers;

use Werp\Transformers\Transformer;

class SupplierTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'document'          => $item['document'],
            'name'              => $item['name'],
            'mobile'            => $item['mobile'],
            'status'            => $item['status'],
            'phone' 			=> $item['phone'],
            'email' 			=> $item['email'],
            'web' 				=> $item['web'],
            'photo' 			=> $item['photo'],
            'description' 		=> $item['description'],
            'contact_person' 	=> $item['contact_person'],
            'economic_activity' => $item['economic_activity'],
            'category_id' 		=> $item['category_id'],
            'address_id' 		=> $item['address_id'],
            'created_at'        => $item['created_at'],
        ];
    }
}
