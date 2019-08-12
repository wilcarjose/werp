<?php

namespace Werp\Modules\Core\Purchases\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Warehouse;

class PurchaseOrderDetailTransformer extends Transformer
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
            'id'                => $item['id'],
            'reference'         => $item['reference'],
            'date'              => $item['date'],
            'qty'               => $item['qty'],
            'product_id'        => $item['product_id'],
            'product_name'      => $this->productName($item['product_id']),
            'warehouse_name'    => $this->warehouseName($item['warehouse_id']),
            'warehouse_id'      => $item['warehouse_id'],
            'created_at'        => $item['created_at'],
            'price'             => $item['price'],
            'tax'               => $item['tax'],
            'discount'          => $item['discount'],
            'full_price'        => $item['full_price'],
            'total_price'       => $item['total_price'],
            'total_tax'         => $item['total_tax'],
            'total_discount'    => $item['total_discount'],
            'total'             => $item['total'],
            'currency'          => $item['currency'],
            'order_id'          => $item['order_id'],
            'tax_id'            => $item['tax_id'],
            'discount_id'       => $item['discount_id'],
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
