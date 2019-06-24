<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Products\Builders\ProductForm;
use Werp\Modules\Core\Products\Builders\ProductList;
use Werp\Modules\Core\Products\Transformers\ProductTransformer;

class ProductController extends Controller
{
    protected $product;
    protected $category;
    protected $brand;
    protected $supplier;
    protected $productTransformer;
    protected $productForm;
    protected $productList;

    public function __construct(
        Product $product,
        ProductTransformer $productTransformer,
        ProductForm $productForm,
        ProductList $productList,
        Category $category,
        Partner $supplier,
        Brand $brand
    ) {
        $this->product            = $product;
        $this->category            = $category;
        $this->supplier            = $supplier;
        $this->brand            = $brand;
        $this->productTransformer = $productTransformer;
        $this->productForm     = $productForm;
        $this->productList     = $productList;
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

            $products = $this->product->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "$search%");
                }
            })
            ->orderBy("$sort", "$order")->paginate(10);

            if ($products->count()<=0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $products->total(),
                'total_pages'  => $products->lastPage(),
                'current_page' => $products->currentPage(),
                'limit'        => $products->perPage()
            ];

            return response([
                'data'        => $this->productTransformer->transformCollection($products->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return $this->productList->view();
        //return view('admin.products.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selects = [
            'categories' => $this->category->where('type', 'product')->get(),
            'suppliers' => $this->supplier->where('is_supplier', 'y')->get(),
            'brands' => $this->brand->where('status', 'active')->get(),
        ];

        return $this->productForm->createPage($selects);
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
            'name'    => 'required|max:255',
        ]);
    
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }
        
        $data = array_only($request->all(), [
            'code',
            'name',
            'description',
            'part_number',
            'partner_id',
            'brand_id',
            'category_id',
            'barcode',
            'link',
        ]);

        $product = $this->product->create($data);

        flash(trans('messages.product-add'), 'success', 'success');
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
        $product = $this->product->find($id);

        if (!$product) {
            flash(trans('messages.product-not-found'), 'info');
            return back();
        }

        return $this->productForm->showPage('edit', $product->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->find($id);

        if (!$product) {
            flash(trans('messages.product-not-found'), 'info');
            return back();
        }

        $selects = [
            'categories' => $this->category->where('type', 'product')->get(),
            'suppliers' => $this->supplier->where('is_supplier', 'y')->get(),
            'brands' => $this->brand->where('status', 'active')->get(),
        ];

        return $this->productForm->editPage($product->toArray(), $selects);
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
        $product = $this->product->find($id);

        if (!$product) {
            flash(trans('messages.product-not-found'), 'info');
            return back();
        }

        $validator = validator()->make($request->all(), [
            'name'  => 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = array_only($request->all(), [
            'code',
            'name',
            'description',
            'part_number',
            'partner_id',
            'brand_id',
            'category_id',
            'barcode',
            'link',
        ]);

        $this->product->where('id', $id)->update($data);

        flash(trans('messages.product-update'), 'success', 'success');
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
        $product = $this->product->find($id);
        $product->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.product-distroy'),
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
        $this->product->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.product-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Switch specified product's active status
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
        $product = $this->product->find($id);

        if ($product) {
            $newStatus = ($product->status == Product::STATE_ACTIVE)? Product::STATE_INACTIVE: Product::STATE_ACTIVE;
            $product->status = $newStatus;
            $product->save();

            // Get New updated Object of Product
            $updated          = $product->toArray();

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->productTransformer->transform($updated),
                    'message'     => trans('messages.product-status', ['status' => $newStatus]),
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
     * Switch bulk products' active status
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

        $products = $this->product->whereIn('id', $request->all())->get();

        if ($products->count() > 0) {
            foreach ($products as $product) {
                $newStatus    = ($product->status == Product::STATE_ACTIVE)? Product::STATE_INACTIVE: Product::STATE_ACTIVE;
                $product->status = $newStatus;
                $product->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.product-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.product-status', ['status' => 'updated']), 'success');
            return back();
        }

        flash(trans('messages.product-update-fail'), 'error');
        return back();
    }
}
