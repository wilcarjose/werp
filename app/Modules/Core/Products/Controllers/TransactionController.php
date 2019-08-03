<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Products\Builders\ProductForm;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Builders\TransactionList;
use Werp\Modules\Core\Products\Transformers\TransactionTransformer;

class TransactionController extends BaseController
{
    protected $category;

    protected $brand;

    protected $supplier;

    public function __construct(
        TransactionService $entityService,
        TransactionTransformer $entityTransformer,
        TransactionList $entityList,
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

    protected function getDependencies()
    {
        return [
        //    'categories' => $this->category->where('type', 'product')->get(),
        //    'suppliers' => $this->supplier->where('is_supplier', 'y')->get(),
        //    'brands' => $this->brand->active()->get(),
        ];
    }


}
