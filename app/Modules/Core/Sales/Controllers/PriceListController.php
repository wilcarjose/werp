<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Sales\Models\Price;
use Werp\Modules\Core\Sales\Models\PriceList;
use Werp\Modules\Core\Sales\Builders\PriceListForm;
use Werp\Modules\Core\Sales\Builders\PriceListList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Services\PriceListService;
use Werp\Modules\Core\Sales\Transformers\PriceTransformer;
use Werp\Modules\Core\Sales\Transformers\PriceListTransformer;

class PriceListController extends BaseController
{
    protected $inputs = [
        //'code',
        'description',
        'starting_at',
        'price_list_type_id',
        'doctype_id',
        'reference_price_list_type_id',
        'operation_id',
    ];

    protected $storeRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required',
        'doctype_id' => 'required',
    ];

    protected $updateRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required',
        'doctype_id' => 'required',
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

    protected $relatedField = 'price_list_id';

    protected $routeBase = 'admin.sales.price_lists';

    public function __construct(
        PriceList $entity,
        Price $entityDetail,
        PriceListForm $entityForm,
        PriceListList $entityList,
        PriceListService $entityService,
        PriceListTransformer $entityTransformer,
        PriceTransformer $entityDetailTransformer
    ) {
        $this->entity            = $entity;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityDetail      = $entityDetail;
        $this->entityService     = $entityService;
        $this->entityDetailTransformer      = $entityDetailTransformer;
    }

    public function process($id)
    {
        try {

            $this->entityService->process($id);

            flash('Lista de precios procesada exitosamente', 'success', 'success');
            return redirect(route($this->routeBase.'.edit', $id));

        } catch (\Exception $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        }
    }

    public function reverse($id)
    {
        try {

            $this->entityService->reverse($id);

            flash('Lista de precios reversada exitosamente', 'success', 'success');
            return redirect(route($this->routeBase.'.edit', $id));

        } catch (\Exception $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        }
    }
}
