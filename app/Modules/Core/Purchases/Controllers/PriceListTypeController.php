<?php

namespace Werp\Modules\Core\Purchases\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Purchases\Builders\PriceListTypeForm;
use Werp\Modules\Core\Purchases\Builders\PriceListTypeList;
use Werp\Modules\Core\Purchases\Services\PriceListTypeService;
use Werp\Modules\Core\Purchases\Transformers\PriceListTypeTransformer;

class PriceListTypeController extends BaseController
{
    protected $inputs = [
        'name',
        'description',
        'currency_id',
    ];

    protected $storeRules = [
        'name'     => 'required|max:255',
        'currency_id' => 'required',
    ];

    protected $updateRules = [
        'name'     => 'required|max:255',
        'currency_id' => 'required',
    ];

    protected $routeBase = 'admin.purchases.price_list_types';

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
