<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Stock;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Sales\Models\PriceListType;
use Werp\Modules\Core\Maintenance\Services\ConfigService;

class ProductService extends BaseService
{
	protected $entity;

    public function __construct(
    	Product $entity,
    	ConfigService $configService
    ) {
        $this->entity = $entity;
        $this->configService = $configService;
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
        		$data[$list->currency] = $price;
        	}

        	return $data;

        })->toArray();
    }
}
