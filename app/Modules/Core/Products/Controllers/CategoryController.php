<?php

namespace Werp\Modules\Core\Products\Controllers;

use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Products\Builders\CategoryForm;
use Werp\Modules\Core\Products\Builders\CategoryList;
use Werp\Modules\Core\Products\Services\CategoryService;
use Werp\Modules\Core\Products\Transformers\CategoryTransformer;

class CategoryController extends BaseController
{
    protected $entityService;
    protected $entityTransformer;
    protected $entityForm;
    protected $entityList;

    public function __construct(CategoryService $entityService, CategoryTransformer $entityTransformer, CategoryForm $entityForm, CategoryList $entityList)
    {
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm     = $entityForm;
        $this->entityList     = $entityList;
    }

    protected $inputs = [
        'name',
        'category_id',
    ];

    protected $storeRules = [
        'name'  => 'required|max:255',
        'category_id'  => 'numeric|nullable',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
        'category_id'  => 'numeric|nullable',
    ];

    protected $routeBase = 'admin.products.categories';
}
