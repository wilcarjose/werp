<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Products\Builders\InventoryForm;
use Werp\Modules\Core\Products\Builders\InventoryList;
use Werp\Modules\Core\Products\Transformers\InventoryTransformer;

class InventoryController extends Controller
{
    protected $inventory;
    protected $inventoryTransformer;
    protected $inventoryForm;
    protected $inventoryList;

    public function __construct(Inventory $inventory, InventoryTransformer $inventoryTransformer, InventoryForm $inventoryForm, InventoryList $inventoryList, Doctype $doctype, Warehouse $warehouse)
    {
        $this->inventory            = $inventory;
        $this->doctype            = $doctype;
        $this->warehouse            = $warehouse;
        $this->inventoryTransformer = $inventoryTransformer;
        $this->inventoryForm     = $inventoryForm;
        $this->inventoryList     = $inventoryList;
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
            $sort   = request()->has('sort')?request()->get('sort'):'code';
            $order  = request()->has('order')?request()->get('order'):'asc';
            $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

            $inventories = $this->inventory->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "$search%");
                }
            })
            ->orderBy("$sort", "$order")->paginate(10);

            if ($inventories->count()<=0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $inventories->total(),
                'total_pages'  => $inventories->lastPage(),
                'current_page' => $inventories->currentPage(),
                'limit'        => $inventories->perPage()
            ];

            return response([
                'data'        => $this->inventoryTransformer->transformCollection($inventories->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return $this->inventoryList->view();
        //return view('admin.inventories.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selects = [
            'doctypes' => $this->doctype->all(),
            'warehouses' => $this->warehouse->all(),
        ];

        return $this->inventoryForm->createInventoryPage($selects);
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
            'code'    => 'required|max:255',
            'doctype_id' => 'required',
            'warehouse_id'    => 'required',
        ]);
    
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }
        
        $data = array_only($request->all(), ['code', 'description', 'doctype_id', 'warehouse_id']);
        $data['date'] = date('Y-m-d');
        $inventory = $this->inventory->create($data);

        flash(trans('messages.inventory-add'), 'success', 'success');
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
        $inventory = $this->inventory->find($id);

        if (!$inventory) {
            flash(trans('messages.inventory-not-found'), 'info');
            return back();
        }

        return $this->inventoryForm->showPage('edit', $inventory->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = $this->inventory->find($id);

        if (!$inventory) {
            flash(trans('messages.inventory-not-found'), 'info');
            return back();
        }

        $selects = [
            'doctypes' => $this->doctype->all(),
            'warehouses' => $this->warehouse->all(),
        ];

        return $this->inventoryForm->editInventoryPage($inventory->toArray(), $selects);
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
        $inventory = $this->inventory->find($id);

        if (!$inventory) {
            flash(trans('messages.inventory-not-found'), 'info');
            return back();
        }

        $validator = validator()->make($request->all(), [
            'code'  => 'required|max:255',
            'doctype_id' => 'required',
            'warehouse_id'    => 'required',
        ]);
        
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        // Prepare input
        $input = array_only($request->all(), ['code', 'description', 'doctype_id', 'warehouse_id']);
        extract($input);

        $inventory->code = $code;
        $inventory->description = $description;
        $inventory->doctype_id = $doctype_id;
        $inventory->warehouse_id = $warehouse_id;
        $inventory->save();

        flash(trans('messages.inventory-update'), 'success', 'success');
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
        $inventory = $this->inventory->find($id);
        $inventory->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.inventory-distroy'),
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
        $this->inventory->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.inventory-distroy'),
            'status_code' => 200
        ], 200);
    }

}
