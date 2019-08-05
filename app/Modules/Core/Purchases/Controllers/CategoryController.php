<?php

namespace Werp\Modules\Core\Purchases\Controllers;

use Werp\Modules\Core\Purchases\Builders\CategoryForm;
use Werp\Modules\Core\Purchases\Builders\CategoryList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Purchases\Services\CategoryService;
use Werp\Modules\Core\Purchases\Transformers\CategoryTransformer;

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
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
    ];

    protected $routeBase = 'admin.purchases.categories';
}
