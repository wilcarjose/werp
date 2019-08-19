<?php

namespace Werp\Modules\Core\Purchases\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Purchases\Builders\SupplierForm;
use Werp\Modules\Core\Purchases\Builders\SupplierList;
use Werp\Modules\Core\Purchases\Services\SupplierService;
use Werp\Modules\Core\Purchases\Transformers\SupplierTransformer;

class SupplierController extends BaseController
{
    protected $entityTransformer;
    protected $entityForm;
    protected $entityList;
    protected $entityService;

    public function __construct(
        SupplierTransformer $entityTransformer,
        SupplierService $entityService,
        SupplierForm $entityForm,
        SupplierList $entityList
    ) {
        $this->entityTransformer = $entityTransformer;
        $this->entityService       = $entityService;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
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
        'address_1',
        'address_2',
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

    protected $routeBase = 'admin.purchases.suppliers';

}
