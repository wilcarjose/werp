<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class ProductTransformer extends Transformer
{
    public function transform($item)
    {
        $data =  [
            'id'          => $item['id'],
            'code'        => $item['code'],
            'name'        => $item['name'],
            'part_number' => $item['part_number'],
            'brand_id'    => $item['brand_id'],
            'partner_id'  => $item['partner_id'],
            'barcode'     => $item['barcode'],
            'link'        => $item['link'],
            'description' => $item['description'],
            'category_id' => $item['category_id'],
            'active'      => $item['active'],
            'code_name'   => $item['code'].' - '.$item['name'],
            'created_at'  => $item['created_at'],
        ];

        $data['VEF'] = isset($item['VEF']) ? $item['VEF'] : 0;
        $data['USD'] = isset($item['USD']) ? $item['USD'] : 0;
        $data['stock'] = isset($item['stock']) ? $item['stock'] : 0;

        return $data;
    }
}
