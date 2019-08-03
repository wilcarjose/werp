<?php

namespace Werp\Modules\Core\Sales\Transformers;

use Werp\Transformers\Transformer;

class CustomerTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                => $item['id'],
            'document'          => $item['document'],
            'name'              => $item['name'],
            'mobile'            => $item['mobile'],
            'active'            => $item['active'],
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
