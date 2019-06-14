<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Products\Models\InventoryDetail;
use Werp\Modules\Core\Products\Builders\InventoryForm;
use Werp\Modules\Core\Products\Builders\InventoryList;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Transformers\InventoryTransformer;
use Werp\Modules\Core\Products\Transformers\InventoryDetailTransformer;

class InventoryController extends Controller
{
    protected $inventory;
    protected $doctype;
    protected $warehouse;
    protected $inventoryDetail;
    protected $inventoryTransformer;
    protected $inventoryDetailTransformer;
    protected $inventoryForm;
    protected $inventoryList;
    protected $doctypeService;

    public function __construct(
        Product $product,
        Inventory $inventory,
        InventoryDetail $inventoryDetail,
        InventoryTransformer $inventoryTransformer,
        InventoryDetailTransformer $inventoryDetailTransformer,
        InventoryForm $inventoryForm,
        InventoryList $inventoryList,
        Doctype $doctype,
        Warehouse $warehouse,
        DoctypeService $doctypeService
    ) {
        $this->inventory            = $inventory;
        $this->inventoryDetail      = $inventoryDetail;
        $this->doctype              = $doctype;
        $this->product              = $product;
        $this->warehouse            = $warehouse;
        $this->inventoryTransformer = $inventoryTransformer;
        $this->inventoryDetailTransformer = $inventoryDetailTransformer;
        $this->inventoryForm        = $inventoryForm;
        $this->inventoryList        = $inventoryList;
        $this->doctypeService       = $doctypeService;
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
            'doctype_id' => 'required',
            'warehouse_id'    => 'required',
        ]);
    
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }
        
        // use transctions
        $data = array_only($request->all(), ['code', 'description', 'doctype_id', 'warehouse_id']);
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['date'] = date('Y-m-d');
        $inventory = $this->inventory->create($data);

        flash(trans('messages.inventory-add'), 'success', 'success');
        return redirect(route('admin.products.inventories.edit', $inventory->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(Request $request, $id)
    {   
        $validator = validator()->make($request->all(), [
            'qty'  => 'required|numeric',
            'product_id' => 'required',
            'warehouse_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        $inventory = $this->inventory->find($id);
        
        $data = array_only($request->all(), ['qty', 'description', 'product_id', 'warehouse_id']);
        $data['reference'] = $inventory->code;
        $data['date'] = date('Y-m-d');
        $data['inventory_id'] = $inventory->id;

        $inventoryDetail = $this->inventoryDetail->create($data);

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->inventoryDetailTransformer->transform($inventoryDetail->toArray()),
                'message'     => trans('messages.inventory-detail-created'),
                'status_code' => 201
            ], 201);
        }
        
        flash(trans('messages.inventory-detail-created'), 'success', 'success');
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
            'doctype_id' => 'required',
            'warehouse_id'    => 'required',
        ]);
        
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        // Prepare input
        $input = array_only($request->all(), ['description', 'warehouse_id']);
        extract($input);

        $inventory->description = $description;
        $inventory->warehouse_id = $warehouse_id;
        $inventory->save();

        flash(trans('messages.inventory-update'), 'success', 'success');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDetail(Request $request, $id, $detail)
    {
        $inventoryDetail = $this->inventoryDetail->find($detail);

        if (!$inventoryDetail) {
            return response(['error' => trans('messages.inventory-detail-not-found')], 401);
        }
        
        $validator = validator()->make($request->all(), [
            'qty'  => 'required|numeric',
            'product_id' => 'required',
            'warehouse_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response(['error' => trans('messages.parameters-fail-validation')], 422);
        }

        // Prepare input
        $input = array_only($request->all(), ['qty', 'product_id', 'warehouse_id', 'description']);
        extract($input);

        $inventoryDetail->qty = $qty;
        $inventoryDetail->description = $description;
        $inventoryDetail->product_id = $product_id;
        $inventoryDetail->warehouse_id = $warehouse_id;
        $inventoryDetail->save();

        if ($request->wantsJson()) {
            return response([
                'data'        => $this->inventoryDetailTransformer->transform($inventoryDetail->toArray()),
                'message'     => trans('messages.inventory-detail-update'),
                'status_code' => 200
            ], 200);
        }
        
        flash(trans('messages.inventory-detail-update'), 'success', 'success');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyDetail($id, $detail)
    {
        $inventory = $this->inventoryDetail->find($detail);
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDetail($id)
    {
        $sort   = request()->has('sort')?request()->get('sort'):'code';
        $order  = request()->has('order')?request()->get('order'):'asc';
        $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

        $detail = $this->inventoryDetail
            ->where('inventory_id', $id)
            ->where(function ($query) use ($search) {
            if ($search) {
                $query->where('prpduct_id', 'like', "$search%")
                    ->where('description', 'like', "$search%");
            }
        })
        ->orderBy("$sort", "$order")->paginate(10);

        if ($detail->count()<=0) {
            return response([
                'status_code' => 404,
                'message'     => trans('messages.not-found')
            ], 404);
        }

        $paginator=[
            'total_count'  => $detail->total(),
            'total_pages'  => $detail->lastPage(),
            'current_page' => $detail->currentPage(),
            'limit'        => $detail->perPage()
        ];

        $data = $this->inventoryDetailTransformer
            ->setProducts($this->product->all())
            ->transformCollection($detail->all());

        return response([
            'data'        => $data,
            'paginator'   => $paginator,
            'status_code' => 200
        ], 200);
    }
}
