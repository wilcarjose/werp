<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Werp\Modules\Core\Sales\Builders\CategoryForm;
use Werp\Modules\Core\Sales\Builders\CategoryList;
use Werp\Modules\Core\Sales\Services\CategoryService;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Transformers\CategoryTransformer;

class CategoryController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    public function __construct(CategoryService $entityService, CategoryTransformer $entityTransformer, CategoryForm $entityForm, CategoryList $entityList)
    {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
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

    protected $routeBase = 'admin.sales.categories';

}