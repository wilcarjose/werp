<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Products\Models\Price;
use Werp\Modules\Core\Products\Builders\PriceForm;
use Werp\Modules\Core\Products\Builders\PriceList;
use Werp\Modules\Core\Products\Transformers\PriceTransformer;
use Werp\Modules\Core\Products\Models\PriceList as EntityDetail;
use Werp\Modules\Core\Products\Transformers\PriceListTransformer as EntityDetailTransformer;

class PriceController extends BaseController
{
    protected $inputs = [
        'name',
        'currency',
        'description'
    ];

    protected $storeRules = [
        'name'     => 'required|max:255',
        'currency' => 'required',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
        'currency'  => 'required',
    ];

    protected $storeDetailRules = [
        'price'  => 'numeric',
        'product_id' => 'required',
    ];

    protected $updateDetailRules = [
        'price'  => 'numeric',
        'product_id' => 'required',
    ];

    protected $detailInputs = [
        'product_id',
        'price'
    ];

    protected $dependencies = [];

    protected $relatedField = 'list_type_id';

    public function __construct(
        Price $entity,
        PriceTransformer $entityTransformer,
        PriceForm $entityForm,
        PriceList $entityList,
        EntityDetail $entityDetail,
        EntityDetailTransformer $entityDetailTransformer

    ) {
        $this->entity            = $entity;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityDetail      = $entityDetail;
        $this->entityDetailTransformer      = $entityDetailTransformer;
    }



    
}
