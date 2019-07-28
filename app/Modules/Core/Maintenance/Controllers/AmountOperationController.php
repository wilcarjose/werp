<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Maintenance\Builders\AmountOperationForm;
use Werp\Modules\Core\Maintenance\Builders\AmountOperationList;
use Werp\Modules\Core\Maintenance\Services\AmountOperationService;
use Werp\Modules\Core\Maintenance\Transformers\AmountOperationTransformer;

class AmountOperationController extends BaseController
{
    protected $inputs = [
        'name',
        'description',
        'operation',
        'value',
        'round',
        'config_key',
    ];

    protected $storeRules = [
        'value' => 'numeric|nullable',
    ];

    protected $updateRules = [
        'value' => 'numeric|nullable',
    ];

    protected $routeBase = 'admin.maintenance.amount_operations';

    public function __construct(
        AmountOperationForm $entityForm,
        AmountOperationList $entityList,
        AmountOperationService $entityService,
        AmountOperationTransformer $entityTransformer
    ) {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
    }

}
