<?php

namespace Werp\Modules\Core\Sales\Controllers\Api;

use Werp\Modules\Core\Sales\Services\CustomerService;
use Werp\Modules\Core\Base\Controllers\BaseApiController;
use Werp\Modules\Core\Sales\Resources\CustomerResource;
use Werp\Modules\Core\Sales\Resources\CustomerCollection;

class CustomerController extends BaseApiController
{
    protected $entityService;
    protected $resource = CustomerResource::class;
    protected $collection = CustomerCollection::class;

    public function __construct(CustomerService $entityService)
    {
        $this->entityService     = $entityService;
    }

    protected $inputs = [
        'name',
        'category_id',
    ];

    protected $storeRules = [
        'name'  => 'required|max:255',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
    ];
}