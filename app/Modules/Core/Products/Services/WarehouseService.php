<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Products\Models\StockLimit;
use Werp\Modules\Core\Maintenance\Services\ConfigService;

class WarehouseService extends BaseService
{
    protected $entity;
    protected $configService;
    
    public function __construct(Warehouse $entity, ConfigService $configService, StockLimit $stockLimit)
    {
        $this->entity = $entity;
        $this->stockLimit = $stockLimit;
        $this->configService = $configService;
    }

    public function postCreate($entity)
    {
        session('company')->setComplete('warehouse');
        return $entity;
    }

    public function postUpdate($entity)
    {
        session('company')->setComplete('warehouse');
        return $entity;
    }

    public function getDefault()
    {
    	$id = $this->configService->getDefaultWarehouse();
    	
    	if (is_null($id)) {
    		return null;
    	}

    	return $this->getActiveById($id);
    }

	public function getFirst()
    {
    	return $this->entity->active()->first();
    }

    public function getDefaultOrFirst()
    {
    	return $this->getDefault() ?: $this->getFirst();
    }

    public function getStockLimitByProduct($productId)
    {
        $warehouses = $this->entity->active()->get();
        $limits = collect([]);
        $all = $this->stockLimit->where('product_id', $productId)->whereNull('warehouse_id')->first();
        if (is_null($all)) {
            $all = new StockLimit();
            $all->warehouse_id = null;
        }
        $limits->push($all);
        foreach ($warehouses as $wh) {
            $limit = $this->stockLimit->where('product_id', $productId)->where('warehouse_id', $wh->id)->first();
            if (is_null($limit)) {
                $limit = new StockLimit();
                $limit->warehouse_id = $wh->id;
            }
            $limits->push($limit);
        }

        return $limits;
    }
}
