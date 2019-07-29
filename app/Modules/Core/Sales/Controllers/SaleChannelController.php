<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Builders\SaleChannelForm;
use Werp\Modules\Core\Sales\Builders\SaleChannelList;
use Werp\Modules\Core\Sales\Services\SaleChannelService;
use Werp\Modules\Core\Sales\Transformers\SaleChannelTransformer;

class SaleChannelController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    public function __construct(
        SaleChannelForm $entityForm,
        SaleChannelList $entityList,
        SaleChannelService $entityService,
        SaleChannelTransformer $entityTransformer
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

    protected $routeBase = 'admin.sales.sales_channels';

}