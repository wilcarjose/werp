<?php

namespace Werp\Modules\Core\Products\Controllers;

use Werp\Modules\Core\Products\Builders\BrandForm;
use Werp\Modules\Core\Products\Builders\BrandList;
use Werp\Modules\Core\Products\Services\BrandService;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Transformers\BrandTransformer;

class BrandController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    protected $inputs = [
        'name',
        'description',
        'country',
    ];

    protected $storeRules = [
        'name'  => 'required',
    ];

    protected $updateRules = [
        'name'  => 'required',
    ];

    protected $routeBase = 'admin.products.brands';

    public function __construct(
        BrandForm $entityForm,
        BrandList $entityList,
        BrandService $entityService,
        BrandTransformer $entityTransformer
    ) {
        $this->entityService            = $entityService;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm     = $entityForm;
        $this->entityList     = $entityList;
    }

}
