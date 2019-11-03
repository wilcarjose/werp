<?php

namespace Werp\Modules\Core\Products\Controllers\Api;

use Werp\Modules\Core\Products\Services\CategoryService;
use Werp\Modules\Core\Base\Controllers\BaseApiController;
use Werp\Modules\Core\Products\Resources\CategoryResource;
use Werp\Modules\Core\Products\Resources\CategoryCollection;

class CategoryController extends BaseApiController
{
    protected $entityService;
    protected $resource = CategoryResource::class;
    protected $collection = CategoryCollection::class;

    public function __construct(CategoryService $entityService)
    {
        $this->entityService     = $entityService;
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