<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Stock;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Products\Models\StockLimit;

class StockService
{
	protected $entity;
	protected $product;
	protected $warehouse;
	protected $productId;
    protected $stockLimit;
	protected $warehouseId;

    public function __construct(Stock $entity, StockLimit $stockLimit)
    {
        $this->entity = $entity;
        $this->stockLimit = $stockLimit;
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

    public function setProductId($productId)
    {
    	$this->productId = $productId;
    	return $this;
    }

    public function setWarehouseId($warehouseId)
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

        $this->limitsStockNotifications($entity);

    	return $entity->qty;
    }

    public function sub($qty)
    {
    	$entity = $this->getStock();

    	$entity->qty = $entity->qty - $qty;
    	$entity->save();

        $this->limitsStockNotifications($entity);

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

    protected function limitsStockNotifications($entity)
    {
        $limit = $this->stockLimit->where('product_id', $entity->product_id)->where('warehouse_id', $entity->warehouse_id)->first();

        if ($limit) {

            if ($entity->qty >= $limit->max_qty) {
                \Log::info('Product ' . $entity->product_id . ' Warehouse ' . $entity->warehouse_id . ' current ' . $entity->qty . ' max ' . $limit->max_qty);
                // notify max
            }

            if ($entity->qty <= $limit->min_qty) {
                \Log::info('Product ' . $entity->product_id . ' Warehouse ' . $entity->warehouse_id . ' current ' . $entity->qty . ' min ' . $limit->min_qty);
                // notify min
            }
        }

        $limit = $this->stockLimit->where('product_id', $entity->product_id)->whereNull('warehouse_id')->first();

        if ($limit) {

            if ($entity->qty >= $limit->max_qty) {
                \Log::info('Product ' . $entity->product_id . ' current ' . $entity->qty . ' max ' . $limit->max_qty);
                // notify max
            }

            if ($entity->qty <= $limit->min_qty) {
                \Log::info('Product ' . $entity->product_id . ' current ' . $entity->qty . ' min ' . $limit->min_qty);
                // notify min
            }
        }
    }
}
