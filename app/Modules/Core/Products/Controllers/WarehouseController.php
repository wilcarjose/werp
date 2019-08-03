<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Products\Builders\WarehouseForm;
use Werp\Modules\Core\Products\Builders\WarehouseList;
use Werp\Modules\Core\Products\Transformers\WarehouseTransformer;

class WarehouseController extends Controller
{
    protected $warehouse;
    protected $warehouseTransformer;
    protected $warehouseForm;
    protected $warehouseList;

    public function __construct(Warehouse $warehouse, WarehouseTransformer $warehouseTransformer, WarehouseForm $warehouseForm, WarehouseList $warehouseList)
    {
        $this->warehouse            = $warehouse;
        $this->warehouseTransformer = $warehouseTransformer;
        $this->warehouseForm     = $warehouseForm;
        $this->warehouseList     = $warehouseList;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // If there is an Ajax request or any request wants json data
        if (request()->ajax() || request()->wantsJson()) {
            $sort   = request()->has('sort')?request()->get('sort'):'name';
            $order  = request()->has('order')?request()->get('order'):'asc';
            $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

            $warehouses = $this->warehouse->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "$search%");
                }
            })
            ->orderBy("$sort", "$order")->paginate(10);

            if ($warehouses->count()<=0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $warehouses->total(),
                'total_pages'  => $warehouses->lastPage(),
                'current_page' => $warehouses->currentPage(),
                'limit'        => $warehouses->perPage()
            ];

            return response([
                'data'        => $this->warehouseTransformer->transformCollection($warehouses->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return $this->warehouseList->view();
        //return view('admin.warehouses.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->warehouseForm->showPage();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = validator()->make($request->all(), [
            'name'    => 'required|max:255',
        ]);
    
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }
        //  Create Warehouse
        $warehouse = $this->warehouse->create(array_only($request->all(), ['name']));

        flash(trans('messages.warehouse-add'), 'success', 'success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = $this->warehouse->find($id);

        if (!$warehouse) {
            flash(trans('messages.warehouse-not-found'), 'info');
            return back();
        }

        return $this->warehouseForm->showPage('edit', $warehouse->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = $this->warehouse->find($id);

        if (!$warehouse) {
            flash(trans('messages.warehouse-not-found'), 'info');
            return back();
        }

        return $this->warehouseForm->editWarehousePage($warehouse->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $warehouse = $this->warehouse->find($id);

        if (!$warehouse) {
            flash(trans('messages.warehouse-not-found'), 'info');
            return back();
        }

        $validator = validator()->make($request->all(), [
            'name'  => 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        // Prepare input
        $input = array_only($request->all(), ['name']);
        extract($input);

        $warehouse->name = $name;
        $warehouse->save();

        flash(trans('messages.warehouse-update'), 'success', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = $this->warehouse->find($id);
        $warehouse->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.warehouse-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Remove the bulk resource from storage.
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
        $this->warehouse->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.warehouse-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Switch specified warehouse's active status
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function switchStatus(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id'   =>'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        extract($request->all());
        $warehouse = $this->warehouse->find($id);

        if ($warehouse) {
            $newStatus = ($warehouse->active == Warehouse::STATUS_ACTIVE)? Warehouse::STATUS_INACTIVE: Warehouse::STATUS_ACTIVE;
            $warehouse->active = $newStatus;
            $warehouse->save();

            // Get New updated Object of Warehouse
            $updated          = $warehouse->toArray();

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->warehouseTransformer->transform($updated),
                    'message'     => trans('messages.warehouse-status', ['status' => $newStatus]),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.admin-status', ['status' => $newStatus]), 'success', 'success');
            return back();
        }

        flash(trans('messages.admin-update-fail'), 'error');
        return back();
    }

    /**
     * Switch bulk warehouses' active status
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function switchStatusBulk(Request $request)
    {
        $input = $request->all();

        if (count($input) == 0) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        $warehouses = $this->warehouse->whereIn('id', $request->all())->get();

        if ($warehouses->count() > 0) {
            foreach ($warehouses as $warehouse) {
                $newStatus    = ($warehouse->active == Warehouse::STATUS_ACTIVE)? Warehouse::STATUS_INACTIVE: Warehouse::STATUS_ACTIVE;
                $warehouse->active = $newStatus;
                $warehouse->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.warehouse-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.warehouse-status', ['status' => 'updated']), 'success');
            return back();
        }

        flash(trans('messages.warehouse-update-fail'), 'error');
        return back();
    }
}
