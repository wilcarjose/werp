<?php

namespace Werp\Modules\Core\Purchases\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Purchases\Builders\SupplierForm;
use Werp\Modules\Core\Purchases\Builders\SupplierList;
use Werp\Modules\Core\Purchases\Transformers\SupplierTransformer;

class SupplierController extends Controller
{
    protected $supplier;
    protected $category;
    protected $supplierTransformer;
    protected $supplierForm;
    protected $supplierList;

    public function __construct(
        Partner $supplier,
        Category $category,
        SupplierTransformer $supplierTransformer,
        SupplierForm $supplierForm,
        SupplierList $supplierList
    ) {
        $this->supplier            = $supplier;
        $this->category            = $category;
        $this->supplierTransformer = $supplierTransformer;
        $this->supplierForm        = $supplierForm;
        $this->supplierList        = $supplierList;
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

            $suppliers = $this->supplier
                ->where('is_supplier', 'y')
                ->where(function ($query) use ($search) {
                    if ($search) {
                        $query->where('name', 'like', "$search%");
                    }
                })
                ->orderBy("$sort", "$order")->paginate(10);

            if ($suppliers->count()<=0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $suppliers->total(),
                'total_pages'  => $suppliers->lastPage(),
                'current_page' => $suppliers->currentPage(),
                'limit'        => $suppliers->perPage()
            ];

            return response([
                'data'        => $this->supplierTransformer->transformCollection($suppliers->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return $this->supplierList->view();
        //return view('admin.suppliers.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selects = [
            'categories' => $this->category->where('type', Partner::SUPPLIER_TYPE)->get(),
        ];

        return $this->supplierForm->createPage($selects);
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
            'document'    => 'required|max:255',
        ]);
    
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = array_only($request->all(), [
            'name',
            'document',
            'phone',
            'mobile',
            'email',
            'web',
            'photo',
            'description',
            'contact_person',
            'economic_activity',
            'category_id',
        ]);

        $data['is_supplier'] = 'y';
        $data['type'] = Partner::SUPPLIER_TYPE;
        //  Create Supplier
        $supplier = $this->supplier->create($data);

        flash(trans('messages.supplier-add'), 'success', 'success');
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
        $supplier = $this->supplier->find($id);

        if (!$supplier) {
            flash(trans('messages.supplier-not-found'), 'info');
            return back();
        }

        return $this->supplierForm->showPage('edit', $supplier->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = $this->supplier->find($id);

        if (!$supplier || $supplier->isNotSupplier()) {
            flash(trans('messages.supplier-not-found'), 'info');
            return back();
        }

        $selects = [
            'categories' => $this->category->where('type', Partner::SUPPLIER_TYPE)->get(),
        ];

        return $this->supplierForm->editPage($supplier->toArray(), $selects );
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
        $supplier = $this->supplier->find($id);

        if (!$supplier) {
            flash(trans('messages.supplier-not-found'), 'info');
            return back();
        }

        $validator = validator()->make($request->all(), [
            'name'  => 'required|max:255',
            'document'  => 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = array_only($request->all(), [
                'name',
                'document',
                'phone',
                'mobile',
                'email',
                'web',
                'photo',
                'description',
                'contact_person',
                'economic_activity',
                'category_id',
            ]
        );

        $data['is_supplier'] = 'y';
        $data['type'] = Partner::SUPPLIER_TYPE;

        $this->supplier->where('id', $id)
            ->update($data);

        flash(trans('messages.supplier-update'), 'success', 'success');
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
        $supplier = $this->supplier->find($id);
        $supplier->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.supplier-distroy'),
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
        $this->supplier->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.supplier-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Switch specified supplier's active status
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
        $supplier = $this->supplier->find($id);

        if ($supplier) {
            $newStatus = ($supplier->active == Partner::STATUS_ACTIVE)? Partner::STATUS_INACTIVE: Partner::STATUS_ACTIVE;
            $supplier->active = $newStatus;
            $supplier->save();

            // Get New updated Object of Supplier
            $updated          = $supplier->toArray();

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->supplierTransformer->transform($updated),
                    'message'     => trans('messages.supplier-status', ['status' => $newStatus]),
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
     * Switch bulk suppliers' active status
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

        $suppliers = $this->supplier->whereIn('id', $request->all())->get();

        if ($suppliers->count() > 0) {
            foreach ($suppliers as $supplier) {
                $newStatus    = ($supplier->active == Supplier::STATUS_ACTIVE)? Supplier::STATUS_INACTIVE: Supplier::STATUS_ACTIVE;
                $supplier->active = $newStatus;
                $supplier->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.supplier-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.supplier-status', ['status' => 'updated']), 'success');
            return back();
        }

        flash(trans('messages.supplier-update-fail'), 'error');
        return back();
    }
}
