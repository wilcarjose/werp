<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;

class InventoryDetailTransformer extends Transformer
{
    protected $products = [];

    public function transform($item)
    {
        return [
            'id'           => $item['id'],
            'reference'    => $item['reference'],
            'description'  => $item['description'],
            'date'         => $item['date'],
            'qty'          => $item['qty'],
            'inventory_id' => $item['inventory_id'],
            'product_id'   => $item['product_id'],
            'product_name' => $this->productName($item['product_id']),
            'warehouse_id' => $item['warehouse_id'],
            'created_at'   => $item['created_at']
        ];
    }

    public function setProducts($products)
    {
        foreach ($products as $product) {
            $this->products[$product['id']] = $product['code'] .' - '.$product['name'];    
        }

        return $this;
    }

    protected function productName($id)
    {
        return isset($this->products[$id]) ? $this->products[$id] : '';
    }
}
