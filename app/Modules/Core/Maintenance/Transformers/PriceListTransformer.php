<?php

namespace Werp\Modules\Core\Maintenance\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\PriceListType;

class PriceListTransformer extends Transformer
{
    protected $listTypes = [];

    public function __construct()
    {        
        if (empty($this->listTypes)) {
            $this->setListTypes(PriceListType::all());
        }
    }

    public function transform($item)
    {
        return [
            'id'                 => $item['id'],
            'code'               => $item['code'],
            'description'        => $item['description'],
            'starting_at'        => $item['starting_at'],
            'state'              => $this->makeState($item),
            'list_name'          => $this->listName($item['price_list_type_id']),
            'price_list_type_id' => $item['price_list_type_id'],
            'updated_at'         => $item['updated_at'],
            'created_at'         => $item['created_at'],
            'reference_price_list_type_id' => $item['reference_price_list_type_id'],
            'operation' => $item['operation'],
            'reference' => $item['reference'],
            'round' => $item['round'],
            'type' => $item['type'],
            'exchange_rate_id' => $item['exchange_rate_id'],
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

    public function setListTypes($listTypes = [])
    {
        foreach ($listTypes as $listType) {
            $this->listTypes[$listType['id']] = $listType['name'] . ' (' . $listType->currency->abbr .')';
        }

        return $this;
    }

    protected function listName($id)
    {
        return isset($this->listTypes[$id]) ? $this->listTypes[$id] : '';
    }
}
