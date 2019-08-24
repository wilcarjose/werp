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
        'amount_operation_id',
        'use_exchange_rate'
    ];

    protected $storeRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required',
        'reference_price_list_type_id' => 'required_if:use_exchange_rate,on',
        'doctype_id' => 'required',
    ];

    protected $updateRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required',
        'reference_price_list_type_id' => 'required_if:use_exchange_rate,on',
        'doctype_id' => 'required',
    ];

    protected $storeDetailRules = [
        //'price'  => 'numeric',
        //'product_id' => 'required',
    ];

    protected $updateDetailRules = [
        //'price'  => 'numeric',
        //'product_id' => 'required',
    ];

    protected $detailInputs = [
        'product_id',
        'price',
        'all',
        'stock',
        'warehouse_id',
        'category_id',
        'brand_id'
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

    /*
    public function storeDetail(Request $request, $id)
    {   
        $validator = validator()->make($request->all(), $this->getStoreDetailRules());
        
        if ($validator->fails()) {
            return response(['error' => trans($this->getFailValidationKey())], 422);
        }

        try {

            $data = array_only($request->all(), $this->getDetailInputs());

            $entityDetail = $this->entityService->createDetail($id, $data);

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans($this->getUpdatedKey()),
                    'status_code' => 201
                ], 201);
            }
            
            flash(trans($this->getUpdatedKey()), 'success', 'success');
            return back();

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();
        }
        
    }
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDetail($id)
    {
        $sort   = request()->has('sort')?request()->get('sort'):'id';
        $order  = request()->has('order')?request()->get('order'):'asc';
        $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

        $entity = $this->entityService->getById($id);

        $detail = $entity->detail->sortBy(function($price, $key) {
          return $price->product->code;
        })->values()->all();

        $totals = $entity->getTotals();

        $data = $this->entityDetailTransformer
            ->transformCollection($detail);
       
        return response([
            'data'        => $data,
            'totals'   => $totals,
            'status_code' => 200
        ], 200);
    }
}
