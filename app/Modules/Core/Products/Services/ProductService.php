<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Stock;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Maintenance\Models\PriceListType;
use Werp\Modules\Core\Products\Models\Transaction;
use Werp\Modules\Core\Maintenance\Services\ConfigService;

class ProductService extends BaseService
{
	protected $entity;

    public function __construct(
    	Product $entity,
    	ConfigService $configService,
        WarehouseService $warehouseService
    ) {
        $this->entity = $entity;
        $this->configService = $configService;
        $this->warehouseService = $warehouseService;
    }

    protected function makeUpdateData($id, $data)
    {
        if (isset($data['partner_id']) && $data['partner_id'] == 'new') {
            $data['partner_id'] = null;
        }

        return $data;
    }

    protected function makeCreateData($data)
    {
        if (isset($data['partner_id']) && $data['partner_id'] == 'new') {
            $data['partner_id'] = null;
        }
        
        return $data;
    }

    public function getProductsStock()
    {
        $entities = $this->entity
        	->active()
            ->orderBy("code", "asc");

        $saleLists = PriceListType::saleLists()->get();

        return $entities->get()->map(function($product) use ($saleLists) {
        	
        	$data = $product->toArray();

        	$warehouse = Warehouse::find($this->configService->getDefaultWarehouse());
        	$warehouse = $warehouse ?: Warehouse::first();

        	$stock = Stock::where('product_id', $product->id)->where('warehouse_id', $warehouse->id)->first();
        	
        	$data['stock'] = $stock ? $stock->qty : 0;
        	$data['brand'] = $product->brand_id ? $product->brand->name : '';
        	$data['uom']   = $product->uom_id ? $product->uom->name : '';

        	foreach ($saleLists as $list) {
        		$price = $product->currentPrice($list->id);
        		$data[$list->currency_abbr] = $price;
        	}

        	return $data;

        })->toArray();
    }

    public function getProductStock($id)
    {
        return Stock::where('product_id', $id)
            ->get()
            ->reject(function ($stock) {
                return $stock->warehouse->active == 'off';
            });
    }

    public function getProductTransactions($id)
    {
        return Transaction::where('product_id', $id)
            ->orderBy('date', 'DESC')
            ->take(10)
            ->get();
    }

    public function getStockLimit($id)
    {
        return $this->warehouseService->getStockLimitByProduct($id);
    }

    public function updateLimitStock($data)
    {
        return $this->warehouseService->updateLimitStock($data);
    }
}
