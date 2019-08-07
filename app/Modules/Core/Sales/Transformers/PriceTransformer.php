<?php

namespace Werp\Modules\Core\Sales\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Products\Models\Product;

class PriceTransformer extends Transformer
{
    protected $products = [];

    public function __construct()
    {        
        if (empty($this->products)) {
            $this->setProducts(Product::all());
        }
    }

    public function transform($item)
    {
        return [
            'id'           => $item['id'],
            'starting_at'  => $item['starting_at'],
            'price'        => $item['price'],
            'before_price'        => $item['before_price'],
            'base_price'        => $item['base_price'],
            'currency'     => $item['currency'],
            'operation_name'     => $item['operation_name'],
            'active'       => $item['active'],
            'created_at'   => $item['created_at'],
            'updated_at'   => $item['updated_at'],
            'product_id'   => $item['product_id'],
            'amount_operation_id'   => $item['amount_operation_id'],
            'price_list_id'   => $item['price_list_id'],
            'price_list_type_id'   => $item['price_list_type_id'],
            'product_name' => $this->productName($item['product_id']),
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
}
