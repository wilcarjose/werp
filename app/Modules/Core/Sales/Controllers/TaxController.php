<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Werp\Modules\Core\Sales\Builders\TaxForm;
use Werp\Modules\Core\Sales\Builders\TaxList;
use Werp\Modules\Core\Sales\Services\TaxService;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Transformers\TaxTransformer;

class TaxController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    public function __construct(
        TaxForm $entityForm,
        TaxList $entityList,
        TaxService $entityService,
        TaxTransformer $entityTransformer
    ) {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
    }

    protected $inputs = [
        'name',
        'description',
        'amount_operation_id',
    ];

    protected $storeRules = [
        'name'  => 'required|max:255',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
    ];

    protected $routeBase = 'admin.sales.taxs';

}