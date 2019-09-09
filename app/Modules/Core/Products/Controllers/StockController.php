<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Products\Services\StockService;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Products\Builders\ProductForm;
use Werp\Modules\Core\Products\Builders\StockList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Transformers\StockTransformer;

class StockController extends BaseController
{
    protected $category;

    protected $brand;

    protected $supplier;

    public function __construct(
        StockService $entityService,
        StockTransformer $entityTransformer,
        StockList $entityList,
        Category $category,
        Partner $supplier,
        Brand $brand
    ) {
        $this->entityService     = $entityService;
        $this->category          = $category;
        $this->supplier          = $supplier;
        $this->brand             = $brand;
        $this->entityTransformer = $entityTransformer;
        $this->entityList        = $entityList;
    }
}
