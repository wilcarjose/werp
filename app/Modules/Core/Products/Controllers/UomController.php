<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Products\Builders\UomForm;
use Werp\Modules\Core\Products\Builders\UomList;
use Werp\Modules\Core\Products\Services\UomService;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Transformers\UomTransformer;

class UomController extends BaseController
{
    protected $inputs = [
        'name',
        'description',
        'abbr',
        'symbol',
    ];

    protected $storeRules = [
        'name'        => 'required',
    ];

    protected $updateRules = [
        'name'        => 'required',
    ];

    protected $routeBase = 'admin.products.uom';

    public function __construct(
        UomForm $entityForm,
        UomList $entityList,
        UomService $entityService,
        UomTransformer $entityTransformer
    ) {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
    }
}
