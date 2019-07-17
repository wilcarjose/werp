<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Stock;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Warehouse;

class StockService
{
	protected $entity;
	protected $product;
	protected $warehouse;
	protected $productId;
	protected $warehouseId;

    public function __construct(Stock $entity)
    {
        $this->entity = $entity;
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
    	$entity = $this->entity->where('product_id', $this->getProductId())
    		->where('warehouse_id', $this->getWarehouseId())
    		->first();

    	if (is_null($entity)) {
    		$entity = $this->initialize();
    	}

    	return $entity;
    }

    public function getQty()
    {
    	$entity = $this->getStock();

    	return $entity->qty;
    }

    public function add($qty)
    {
    	$entity = $this->getStock();

    	$entity->qty = $entity->qty + $qty;
    	$entity->save();

    	return $entity->qty;
    }

    public function sub($qty)
    {
    	$entity = $this->getStock();

    	$entity->qty = $entity->qty - $qty;
    	$entity->save();

    	return $entity->qty;
    }

    protected function initialize()
    {
    	$entity = new Stock;
    	$entity->warehouse_id = $this->getWarehouseId();
    	$entity->product_id = $this->getProductId();
    	$entity->qty = 0;
    	$entity->save();

    	return $entity;
    }

    public function getResults($sort, $order, $search, $paginate)
    {
        $entities = $this->entity->with('warehouse')->with('product')->where(function ($query) use ($search) {
            //if ($search) {
            //    $query->where('name', 'like', "$search%");
            //}
        })
        ->orderBy("$sort", "$order");
//dd($entities->get()->toArray());
        $total = $entities->count();

        if ($total <= 0) {
            return [];
        }

        $entities = $paginate == 'off' ? $entities : $entities->paginate(10);

        $paginator = $paginate == 'off' ? [
                'total_count'  => $total,
                'total_pages'  => 1,
                'current_page' => 1,
                'limit'        => $total
            ] : [
                'total_count'  => $entities->total(),
                'total_pages'  => $entities->lastPage(),
                'current_page' => $entities->currentPage(),
                'limit'        => $entities->perPage()
            ];

        $data = $paginate == 'off' ? $entities->get()->toArray() : $entities->all();

        return [$data, $paginator];
    }
}
