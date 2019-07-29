<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Werp\Modules\Core\Sales\Builders\DiscountForm;
use Werp\Modules\Core\Sales\Builders\DiscountList;
use Werp\Modules\Core\Sales\Services\DiscountService;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Transformers\DiscountTransformer;

class DiscountController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    public function __construct(
        DiscountForm $entityForm,
        DiscountList $entityList,
        DiscountService $entityService,
        DiscountTransformer $entityTransformer
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

    protected $routeBase = 'admin.sales.discounts';

}