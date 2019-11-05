<?php

namespace Werp\Modules\Core\Products\Controllers\Api;

use Werp\Modules\Core\Products\Services\ProductService;
use Werp\Modules\Core\Base\Controllers\BaseApiController;
use Werp\Modules\Core\Products\Resources\ProductResource;
use Werp\Modules\Core\Products\Resources\ProductCollection;

class ProductController extends BaseApiController
{
    protected $entityService;
    protected $resource = ProductResource::class;
    protected $collection = ProductCollection::class;

    public function __construct(ProductService $entityService)
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