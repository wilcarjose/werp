<?php

namespace Werp\Modules\Core\Sales\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class PriceListTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                 => $item['id'],
            'code'               => $item['code'],
            'description'        => $item['description'],
            'starting_at'        => $item['starting_at'],
            'state'              => $this->makeState($item),
            //'state'              => $item['state'],
            'price_list_type_id' => $item['price_list_type_id'],
            'updated_at'         => $item['updated_at'],
            'created_at'         => $item['created_at'],
            'reference_price_list_type_id' => $item['reference_price_list_type_id'],
            'operation' => $item['operation'],
            'reference' => $item['reference'],
            'round' => $item['round'],
        ];
    }

    protected function makeState($item)
    {
        $data = config('products.document.actions.'.Basedoc::PL_DOC.'.'.$item['state']);

        return [
            'name' => trans($data['after_name']),
            'color' => $data['color'],
            'key' => $data['key'],
            'state' => $item['state']
        ];
    }
}
