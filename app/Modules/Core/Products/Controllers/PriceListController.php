<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Products\Models\Price;
use Werp\Modules\Core\Products\Models\PriceList;
use Werp\Modules\Core\Products\Builders\PriceListForm;
use Werp\Modules\Core\Products\Builders\PriceListList;
use Werp\Modules\Core\Products\Services\PriceListService;
use Werp\Modules\Core\Products\Transformers\PriceTransformer;
use Werp\Modules\Core\Products\Transformers\PriceListTransformer;

class PriceListController extends BaseController
{
    protected $inputs = [
        //'code',
        'description',
        'starting_at',
        'price_list_type_id',
        'doctype_id',
        'reference_price_list_type_id',
        'operation',
        'reference',
        'round',
    ];

    protected $storeRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required|numeric',
        'doctype_id' => 'required|numeric',
        'reference' => 'numeric|nullable',
    ];

    protected $updateRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required|numeric',
        'doctype_id' => 'required|numeric',
        'reference' => 'numeric|nullable',
    ];

    protected $storeDetailRules = [
        'price'  => 'numeric',
        'product_id' => 'required|numeric',
    ];

    protected $updateDetailRules = [
        'price'  => 'numeric',
        'product_id' => 'required|numeric',
    ];

    protected $detailInputs = [
        'product_id',
        'price'
    ];

    protected $dependencies = [];

    protected $relatedField = 'price_list_id';

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
            return redirect(route('admin.products.price_lists.edit', $id));

        } catch (\Exception $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.price_lists.edit', $id));
        }
    }

    public function reverse($id)
    {
        try {

            $this->entityService->reverse($id);

            flash('Lista de precios reversada exitosamente', 'success', 'success');
            return redirect(route('admin.products.price_lists.edit', $id));

        } catch (\Exception $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.price_lists.edit', $id));
        }
    }
}
