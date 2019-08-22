<?php

namespace Werp\Modules\Core\Maintenance\Transformers;

use Werp\Transformers\Transformer;

class CurrencyTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'            => $item['id'],
            'name'          => $item['name'],
            'name_and_abbr' => $item['name'] . ' - '.$item['abbr'],
            'description'   => $item['description'],            
            'abbr'          => $item['abbr'],
            'symbol'        => $item['symbol'],
            'numeric_code'  => $item['numeric_code'],
            'active'        => $item['active'],
            'created_at'    => $item['created_at'],
            'updated_at'    => $item['updated_at'],
        ];
    }
}