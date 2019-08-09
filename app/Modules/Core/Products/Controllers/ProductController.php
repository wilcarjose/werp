<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Products\Models\Uom;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Services\ProductService;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Products\Builders\ProductForm;
use Werp\Modules\Core\Products\Builders\ProductList;
use Werp\Modules\Core\Products\Transformers\ProductTransformer;

class ProductController extends BaseController
{
    protected $category;

    protected $brand;

    protected $supplier;

    protected $inputs = [
        'code',
        'name',
        'description',
        'part_number',
        'partner_id',
        'brand_id',
        'category_id',
        'barcode',
        'link',
        'uom_id',
    ];

    protected $storeRules = [
        'code'    => 'required|max:255',
        'name'    => 'required|max:255',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
    ];

    protected $routeBase = 'admin.products.products';

    public function __construct(
        ProductService $entityService,
        ProductTransformer $entityTransformer,
        ProductForm $entityForm,
        ProductList $entityList,
        Category $category,
        Partner $supplier,
        Brand $brand
    ) {
        $this->entityService            = $entityService;
        $this->category          = $category;
        $this->supplier          = $supplier;
        $this->brand             = $brand;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
    }
}
