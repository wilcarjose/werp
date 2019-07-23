<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Products\Builders\BrandForm;
use Werp\Modules\Core\Products\Builders\BrandList;
use Werp\Modules\Core\Products\Transformers\BrandTransformer;

class BrandController extends Controller
{
    protected $brand;
    protected $brandTransformer;
    protected $brandForm;
    protected $brandList;

    public function __construct(Brand $brand, BrandTransformer $brandTransformer, BrandForm $brandForm, BrandList $brandList)
    {
        $this->brand            = $brand;
        $this->brandTransformer = $brandTransformer;
        $this->brandForm     = $brandForm;
        $this->brandList     = $brandList;
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

            $brands = $this->brand->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "$search%");
                }
            })
            ->orderBy("$sort", "$order")->paginate(10);

            if ($brands->count()<=0) {
                return response([
                    'status_code' => 404,
                    //'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $brands->total(),
                'total_pages'  => $brands->lastPage(),
                'current_page' => $brands->currentPage(),
                'limit'        => $brands->perPage()
            ];

            return response([
                'data'        => $this->brandTransformer->transformCollection($brands->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return $this->brandList->view();
        //return view('admin.brands.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->brandForm->showPage();
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
        //  Create Brand
        $brand = $this->brand->create(array_only($request->all(), ['name', 'description', 'country']));

        flash(trans('messages.brand-add'), 'success', 'success');
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
        $brand = $this->brand->find($id);

        if (!$brand) {
            flash(trans('messages.brand-not-found'), 'info');
            return back();
        }

        return $this->brandForm->showPage('edit', $brand->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->brand->find($id);

        if (!$brand) {
            flash(trans('messages.brand-not-found'), 'info');
            return back();
        }

        return $this->brandForm->editPage($brand->toArray());
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
        $brand = $this->brand->find($id);

        if (!$brand) {
            flash(trans('messages.brand-not-found'), 'info');
            return back();
        }

        $validator = validator()->make($request->all(), [
            'name'  => 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = array_only($request->all(), ['name', 'description', 'country']);
        
        $this->brand->where('id', $id)->update($data);

        flash(trans('messages.brand-update'), 'success', 'success');
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
        $brand = $this->brand->find($id);
        $brand->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.brand-distroy'),
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
        $this->brand->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.brand-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Switch specified brand's active status
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
        $brand = $this->brand->find($id);

        if ($brand) {
            $newStatus = ($brand->status == Brand::STATE_ACTIVE)? Brand::STATE_INACTIVE: Brand::STATE_ACTIVE;
            $brand->status = $newStatus;
            $brand->save();

            // Get New updated Object of Brand
            $updated          = $brand->toArray();

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->brandTransformer->transform($updated),
                    'message'     => trans('messages.brand-status', ['status' => $newStatus]),
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
     * Switch bulk brands' active status
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

        $brands = $this->brand->whereIn('id', $request->all())->get();

        if ($brands->count() > 0) {
            foreach ($brands as $brand) {
                $newStatus    = ($brand->status == Brand::STATE_ACTIVE)? Brand::STATE_INACTIVE: Brand::STATE_ACTIVE;
                $brand->status = $newStatus;
                $brand->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.brand-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.brand-status', ['status' => 'updated']), 'success');
            return back();
        }

        flash(trans('messages.brand-update-fail'), 'error');
        return back();
    }
}
