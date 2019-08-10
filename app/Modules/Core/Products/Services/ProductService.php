<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Stock;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Sales\Models\PriceListType;

class ProductService extends BaseService
{
	protected $entity;

    public function __construct(
    	Product $entity
    ) {
        $this->entity = $entity;
    }

    public function getProductsStock()
    {
        $entities = $this->entity
        	->active()
            ->orderBy("code", "asc");

        $saleLists = PriceListType::saleLists()->get();

        return $entities->get()->map(function($product) use ($saleLists) {
        	$data = $product->toArray();
        	$stock = Stock::where('product_id', $product->id)->get();

        	$data['stock'] = '';
        	foreach ($stock as $stk) {
        		$data['stock'] = ' '.$stk->warehouse->name .': '.$stk->qty;
        	}

        	foreach ($saleLists as $list) {
        		$price = $product->currentPrice($list->id);
        		$data[$list->currency] = $price;
        	}
        	return $data;
        })->toArray();
    }
}
