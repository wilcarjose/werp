<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Builders\PaymentMethodForm;
use Werp\Modules\Core\Sales\Builders\PaymentMethodList;
use Werp\Modules\Core\Sales\Services\PaymentMethodService;
use Werp\Modules\Core\Sales\Transformers\PaymentMethodTransformer;

class PaymentMethodController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    public function __construct(
        PaymentMethodForm $entityForm,
        PaymentMethodList $entityList,
        PaymentMethodService $entityService,
        PaymentMethodTransformer $entityTransformer
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
        'amount_operation_id'  => 'numeric|nullable',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
        'amount_operation_id'  => 'numeric|nullable',
    ];

    protected $routeBase = 'admin.sales.payment_methods';

}