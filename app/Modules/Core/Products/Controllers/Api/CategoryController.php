<?php

namespace Werp\Modules\Core\Products\Controllers\Api;

use Werp\Modules\Core\Products\Services\CategoryService;
use Werp\Modules\Core\Base\Controllers\BaseApiController;
use Werp\Modules\Core\Products\Transformers\CategoryTransformer;

class CategoryController extends BaseApiController
{
    protected $entityService;
    protected $entityTransformer;

    public function __construct(CategoryService $entityService, CategoryTransformer $entityTransformer)
    {
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
}