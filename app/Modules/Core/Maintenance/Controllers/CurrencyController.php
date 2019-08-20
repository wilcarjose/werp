<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Maintenance\Builders\CurrencyForm;
use Werp\Modules\Core\Maintenance\Builders\CurrencyList;
use Werp\Modules\Core\Maintenance\Services\CurrencyService;
use Werp\Modules\Core\Maintenance\Transformers\CurrencyTransformer;

class CurrencyController extends BaseController
{
    protected $inputs = [
        'name',
        'description',
        'abbr',
        'symbol',
        'numeric_code',
    ];

    protected $storeRules = [
        'name' => 'required',
    ];

    protected $updateRules = [
        'name' => 'required',
    ];

    protected $routeBase = 'admin.maintenance.currencies';

    public function __construct(
        CurrencyForm $entityForm,
        CurrencyList $entityList,
        CurrencyService $entityService,
        CurrencyTransformer $entityTransformer
    ) {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
    }

}
