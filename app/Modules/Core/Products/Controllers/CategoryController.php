<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Products\Builders\CategoryForm;
use Werp\Modules\Core\Products\Builders\CategoryList;
use Werp\Modules\Core\Products\Transformers\CategoryTransformer;

class CategoryController extends Controller
{
    protected $category;
    protected $categoryTransformer;
    protected $categoryForm;
    protected $categoryList;

    public function __construct(Category $category, CategoryTransformer $categoryTransformer, CategoryForm $categoryForm, CategoryList $categoryList)
    {
        $this->category            = $category;
        $this->categoryTransformer = $categoryTransformer;
        $this->categoryForm     = $categoryForm;
        $this->categoryList     = $categoryList;
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

            $categories = $this->category->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "$search%");
                }
            })
            ->orderBy("$sort", "$order")->paginate(10);

            if ($categories->count()<=0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $categories->total(),
                'total_pages'  => $categories->lastPage(),
                'current_page' => $categories->currentPage(),
                'limit'        => $categories->perPage()
            ];

            return response([
                'data'        => $this->categoryTransformer->transformCollection($categories->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return $this->categoryList->view();
        //return view('admin.categories.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->categoryForm->showPage();
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
        //  Create Category
        $category = $this->category->create(array_only($request->all(), ['name']));

        flash(trans('messages.category-add'), 'success', 'success');
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
        $category = $this->category->find($id);

        if (!$category) {
            flash(trans('messages.category-not-found'), 'info');
            return back();
        }

        return $this->categoryForm->showPage('edit', $category->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            flash(trans('messages.category-not-found'), 'info');
            return back();
        }

        return $this->categoryForm->editCategoryPage($category->toArray());
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
        $category = $this->category->find($id);

        if (!$category) {
            flash(trans('messages.category-not-found'), 'info');
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

        $category->name = $name;
        $category->save();

        flash(trans('messages.category-update'), 'success', 'success');
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
        $category = $this->category->find($id);
        $category->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.category-distroy'),
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
        $this->category->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.category-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Switch specified category's active status
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
        $category = $this->category->find($id);

        if ($category) {
            $newStatus = ($category->status == Category::STATE_ACTIVE)? Category::STATE_INACTIVE: Category::STATE_ACTIVE;
            $category->status = $newStatus;
            $category->save();

            // Get New updated Object of Category
            $updated          = $category->toArray();

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->categoryTransformer->transform($updated),
                    'message'     => trans('messages.category-status', ['status' => $newStatus]),
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
     * Switch bulk categories' active status
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

        $categories = $this->category->whereIn('id', $request->all())->get();

        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                $newStatus    = ($category->status == Category::STATE_ACTIVE)? Category::STATE_INACTIVE: Category::STATE_ACTIVE;
                $category->status = $newStatus;
                $category->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.category-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.category-status', ['status' => 'updated']), 'success');
            return back();
        }

        flash(trans('messages.category-update-fail'), 'error');
        return back();
    }
}
