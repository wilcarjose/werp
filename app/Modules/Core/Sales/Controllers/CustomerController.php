<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Sales\Builders\CustomerForm;
use Werp\Modules\Core\Sales\Builders\CustomerList;
use Werp\Modules\Core\Sales\Services\CustomerService;
use Werp\Modules\Core\Sales\Transformers\CustomerTransformer;

class CustomerController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityService;
    protected $entityTransformer;

    public function __construct(
        CustomerForm $entityForm,
        CustomerList $entityList,
        CustomerService $entityService,
        CustomerTransformer $entityTransformer
    ) {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
    }

    protected $inputs = [
        'name',
        'document',
        'phone',
        'mobile',
        'email',
        'web',
        'photo',
        'description',
        'contact_person',
        'economic_activity',
        'category_id',
    ];

    protected $storeRules = [
        'name'  => 'required|max:255',
        'document'  => 'required|max:255',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
        'document'  => 'required|max:255',
    ];

    protected $routeBase = 'admin.sales.customers';
 
}
