<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Stock;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Warehouse;

class StockService
{
	protected $stock;
	protected $product;
	protected $warehouse;
	protected $productId;
	protected $warehouseId;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function setProduct(Product $product)
    {
    	$this->product = $product;
    	return $this;
    }

    public function setWarehouse(Warehouse $warehouse)
    {
    	$this->warehouse = $warehouse;
    	return $this;
    }

    public function setProductId(int $productId)
    {
    	$this->productId = $productId;
    	return $this;
    }

    public function setWarehouseId(int $warehouseId)
    {
    	$this->warehouseId = $warehouseId;
    	return $this;
    }

    public function getProductId()
    {
    	return $this->product ? $this->product->id : $this->productId;
    }

    public function getWarehouseId()
    {
    	return $this->warehouse ? $this->warehouse->id : $this->warehouseId;
    }

    public function getStock()
    {
    	$stock = $this->stock->where('product_id', $this->getProductId())
    		->where('warehouse_id', $this->getWarehouseId())
    		->first();

    	if (is_null($stock)) {
    		$stock = $this->initialize();
    	}

    	return $stock;
    }

    public function getQty()
    {
    	$stock = $this->getStock();

    	return $stock->qty;
    }

    public function add($qty)
    {
    	$stock = $this->getStock();

    	$stock->qty = $stock->qty + $qty;
    	$stock->save();

    	return $stock->qty;
    }

    public function sub($qty)
    {
    	$stock = $this->getStock();

    	$stock->qty = $stock->qty - $qty;
    	$stock->save();

    	return $stock->qty;
    }

    protected function initialize()
    {
    	$stock = new Stock;
    	$stock->warehouse_id = $this->getWarehouseId();
    	$stock->product_id = $this->getProductId();
    	$stock->qty = 0;
    	$stock->save();

    	return $stock;
    }
}
