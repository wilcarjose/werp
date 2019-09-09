<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Services\WarehouseService;
use Werp\Modules\Core\Products\Builders\WarehouseForm;
use Werp\Modules\Core\Products\Builders\WarehouseList;
use Werp\Modules\Core\Products\Transformers\WarehouseTransformer;

class WarehouseController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    protected $inputs = [
        'name',
        'abbr',
        'color',
    ];

    protected $storeRules = [
        'name'        => 'required',
    ];

    protected $updateRules = [
        'name'        => 'required',
    ];

    protected $routeBase = 'admin.products.warehouses';

    public function __construct(WarehouseService $entityService, WarehouseTransformer $entityTransformer, WarehouseForm $entityForm, WarehouseList $entityList)
    {
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm     = $entityForm;
        $this->entityList     = $entityList;
    }
}
