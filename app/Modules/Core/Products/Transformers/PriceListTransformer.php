<?php

namespace Werp\Modules\Core\Products\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Products\Models\Product;

class PriceListTransformer extends Transformer
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
            'price'    => $item['price'],
            'description'  => $item['description'],
            'date'         => $item['date'],
            'currency'          => $item['currency'],
            'list_type_id' => $item['list_type_id'],
            'product_id'   => $item['product_id'],
            'product_name' => $this->productName($item['product_id']),
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
}
