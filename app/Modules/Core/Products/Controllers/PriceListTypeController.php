<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Products\Models\PriceListType;
use Werp\Modules\Core\Products\Builders\PriceListTypeForm;
use Werp\Modules\Core\Products\Builders\PriceListTypeList;
use Werp\Modules\Core\Products\Transformers\PriceListTypeTransformer;

class PriceListTypeController extends BaseController
{
    protected $category;

    protected $brand;

    protected $supplier;

    protected $inputs = [
        'name',
        'description',
        'currency',
        'type',
    ];

    protected $storeRules = [
        'name'     => 'required|max:255',
        'currency' => 'required',
        'type'     => 'required|in:sales,purchases,all',
    ];

    protected $updateRules = [
        'name'     => 'required|max:255',
        'currency' => 'required',
        'type'     => 'required|in:sales,purchases,all',
    ];

    public function __construct(
        PriceListType $entity,
        PriceListTypeTransformer $entityTransformer,
        PriceListTypeForm $entityForm,
        PriceListTypeList $entityList
    ) {
        $this->entity            = $entity;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
    }
}
