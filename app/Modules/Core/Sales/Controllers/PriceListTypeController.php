<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Builders\PriceListTypeForm;
use Werp\Modules\Core\Sales\Builders\PriceListTypeList;
use Werp\Modules\Core\Sales\Services\PriceListTypeService;
use Werp\Modules\Core\Sales\Transformers\PriceListTypeTransformer;

class PriceListTypeController extends BaseController
{
    protected $category;

    protected $brand;

    protected $supplier;

    protected $inputs = [
        'name',
        'description',
        'currency',
        'type',
    ];

    protected $storeRules = [
        'name'     => 'required|max:255',
        'currency' => 'required',
        'type'     => 'required|in:sales,purchases,all',
    ];

    protected $updateRules = [
        'name'     => 'required|max:255',
        'currency' => 'required',
        'type'     => 'required|in:sales,purchases,all',
    ];

    protected $routeBase = 'admin.sales.price_list_types';

    public function __construct(
        PriceListTypeForm $entityForm,
        PriceListTypeList $entityList,
        PriceListTypeService $entityService,
        PriceListTypeTransformer $entityTransformer
    ) {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
    }
}
