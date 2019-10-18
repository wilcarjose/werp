<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Warehouse;

class InventoryLineTransformer extends Transformer
{
    protected $products = [];
    protected $warehouses = [];

    public function __construct()
    {
        if (empty($this->products)) {
            $this->setProducts(Product::all());
        }

        if (empty($this->warehouses)) {
            $this->setWarehouses(Warehouse::all());
        }
    }

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
            'warehouse_name' => $this->warehouseName($item['warehouse_id']),
            'created_at'   => $item['created_at']
        ];
    }

    public function setProducts($products = [])
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

    public function setWarehouses($warehouses = [])
    {
        foreach ($warehouses as $warehouse) {
            $this->warehouses[$warehouse['id']] = $warehouse['name'];
        }

        return $this;
    }

    protected function warehouseName($id)
    {
        return isset($this->warehouses[$id]) ? $this->warehouses[$id] : '';
    }
}
