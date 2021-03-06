<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Maintenance\Models\Price;
use Werp\Modules\Core\Maintenance\Models\PriceList;
use Werp\Modules\Core\Maintenance\Builders\PriceListForm;
use Werp\Modules\Core\Maintenance\Builders\PriceListList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Maintenance\Services\PriceListService;
use Werp\Modules\Core\Maintenance\Transformers\PriceTransformer;
use Werp\Modules\Core\Maintenance\Transformers\PriceListTransformer;

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
        'type',
        'file',
    ];

    protected $storeRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required',
        'doctype_id' => 'required',
    ];

    protected $updateRules = [
        'starting_at'        => 'required|date',
        'price_list_type_id' => 'required',
        'reference_price_list_type_id' => 'required_if:type,exchange|required_if:type,formula',
        'amount_operation_id' => 'required_if:type,formula',
        'doctype_id' => 'required',
        'file' => 'required_if:type,import|file|mimes:csv,xls,xlsx,doc,docx,ppt,pptx,ods,odt,odp',
    ];

    protected $storeLineRules = [
        'price'  => 'numeric',
        //'product_id' => 'required',
    ];

    protected $updateLineRules = [
        'price'  => 'numeric',
        //'product_id' => 'required',
    ];

    protected $lineInputs = [
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

    protected $routeBase = 'admin.maintenance.price_lists';

    protected $showSuccess = false;

    public function __construct(
        PriceList $entity,
        Price $entityLine,
        PriceListForm $entityForm,
        PriceListList $entityList,
        PriceListService $entityService,
        PriceListTransformer $entityTransformer,
        PriceTransformer $entityLineTransformer
    ) {
        $this->entity            = $entity;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityLine      = $entityLine;
        $this->entityService     = $entityService;
        $this->entityLineTransformer      = $entityLineTransformer;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            return $this->entityForm->createPage($this->getDependencies(), $this->getDefaultsDependencies());

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());
            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            flash($message, 'error', 'error');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {

            $entity = $this->entityService->getById($id);

            if (!$entity) {
                flash(trans($this->getNotFoundKey()), 'info');
                return back();
            }

            $hasProducts = $entity->lines->isNotEmpty();
            return $this->entityForm->editListPage($entity->toArray(), $hasProducts);

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());
            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            flash($message, 'error', 'error');
            return back();
        }
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
    public function storeLine(Request $request, $id)
    {
        $validator = validator()->make($request->all(), $this->getStoreLineRules());

        if ($validator->fails()) {
            return response(['error' => trans($this->getFailValidationKey())], 422);
        }

        try {

            $data = array_only($request->all(), $this->getLineInputs());

            $entityLine = $this->entityService->createLine($id, $data);

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
    public function indexLine($id)
    {
        $sort   = request()->has('sort')?request()->get('sort'):'id';
        $order  = request()->has('order')?request()->get('order'):'asc';
        $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

        $entity = $this->entityService->getById($id);

        $line = $entity->lines->sortBy(function($price, $key) {
          return $price->product->code;
        })->values()->all();

        $totals = $entity->getTotals();

        $data = $this->entityLineTransformer
            ->transformCollection($line);

        return response([
            'data'        => $data,
            'totals'   => $totals,
            'status_code' => 200
        ], 200);
    }
}
