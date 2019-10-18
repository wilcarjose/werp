<?php

namespace Werp\Modules\Core\Purchases\Transformers;

use Werp\Transformers\Transformer;
use Werp\Modules\Core\Products\Models\Product;

class InvoiceLineTransformer extends Transformer
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
            'id' => $item['id'],
            'date' => $item['date'],
            'reference' => $item['reference'],
            'price' => $item['price'],
            'tax' => $item['tax'],
            'discount' => $item['discount'],
            'full_price' => $item['full_price'],
            'total_price' => $item['total_price'],
            'total_tax' => $item['total_tax'],
            'total_discount' => $item['total_discount'],
            'total' => $item['total'],
            'currency_id' => $item['currency_id'],
            'qty' => $item['qty'],
            'invoice_id' => $item['invoice_id'],
            'product_id' => $item['product_id'],
            'product_name' => $this->productName($item['product_id']),
            'tax_id' => $item['tax_id'],
            'discount_id' => $item['discount_id'],
            'price_id' => $item['price_id'],
            'order_line_id' => $item['order_line_id'],
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
