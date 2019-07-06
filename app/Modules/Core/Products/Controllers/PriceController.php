<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Price;
use Werp\Modules\Core\Products\Builders\PriceForm;
use Werp\Modules\Core\Products\Builders\PriceList;
use Werp\Modules\Core\Products\Transformers\PriceTransformer;

class PriceController extends Controller
{
    protected $price;
    protected $priceTransformer;
    protected $priceForm;
    protected $priceList;

    public function __construct(Price $price, PriceTransformer $priceTransformer, PriceForm $priceForm, PriceList $priceList)
    {
        $this->price            = $price;
        $this->priceTransformer = $priceTransformer;
        $this->priceForm     = $priceForm;
        $this->priceList     = $priceList;
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

            $prices = $this->price->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "$search%");
                }
            })
            ->orderBy("$sort", "$order")->paginate(10);

            if ($prices->count()<=0) {
                return response([
                    'status_code' => 404,
                    'message'     => trans('messages.not-found')
                ], 404);
            }

            $paginator=[
                'total_count'  => $prices->total(),
                'total_pages'  => $prices->lastPage(),
                'current_page' => $prices->currentPage(),
                'limit'        => $prices->perPage()
            ];

            return response([
                'data'        => $this->priceTransformer->transformCollection($prices->all()),
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }
        return $this->priceList->view();
        //return view('admin.prices.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->priceForm->createPage();
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
            'currency'    => 'required',
        ]);
    
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }
        //  Create Price
        $price = $this->price->create(array_only($request->all(), ['name', 'description', 'currency']));

        flash(trans('messages.price-add'), 'success', 'success');
        return redirect(route('admin.products.prices.edit', $price->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $price = $this->price->find($id);

        if (!$price) {
            flash(trans('messages.price-not-found'), 'info');
            return back();
        }

        return $this->priceForm->showPage('edit', $price->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $price = $this->price->find($id);

        if (!$price) {
            flash(trans('messages.price-not-found'), 'info');
            return back();
        }

        return $this->priceForm->editPage($price->toArray());
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
        $price = $this->price->find($id);

        if (!$price) {
            flash(trans('messages.price-not-found'), 'info');
            return back();
        }

        $validator = validator()->make($request->all(), [
            'name'  => 'required|max:255',
            'currency'  => 'required',
        ]);
        
        if ($validator->fails()) {
            flash(trans('messages.parameters-fail-validation'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        // Prepare input
        $data = array_only($request->all(), ['name', 'description', 'currency']);
        $this->price->where('id', $id)
            ->update($data);

        flash(trans('messages.price-update'), 'success', 'success');
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
        $price = $this->price->find($id);
        $price->delete();
        return response([
            'data'        => [],
            'message'     => trans('messages.price-distroy'),
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
        $this->price->destroy($request->all());

        return response([
            'data'        => [],
            'message'     => trans('messages.price-distroy'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Switch specified price's active status
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
        $price = $this->price->find($id);

        if ($price) {
            $newStatus = ($price->status == Price::STATE_ACTIVE)? Price::STATE_INACTIVE: Price::STATE_ACTIVE;
            $price->status = $newStatus;
            $price->save();

            // Get New updated Object of Price
            $updated          = $price->toArray();

            if ($request->wantsJson()) {
                return response([
                    'data'        => $this->priceTransformer->transform($updated),
                    'message'     => trans('messages.price-status', ['status' => $newStatus]),
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
     * Switch bulk prices' active status
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

        $prices = $this->price->whereIn('id', $request->all())->get();

        if ($prices->count() > 0) {
            foreach ($prices as $price) {
                $newStatus    = ($price->status == Price::STATE_ACTIVE)? Price::STATE_INACTIVE: Price::STATE_ACTIVE;
                $price->status = $newStatus;
                $price->save();
            }

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans('messages.price-status', ['status' => 'updated']),
                    'status_code' => 200
                ], 200);
            }

            flash(trans('messages.price-status', ['status' => 'updated']), 'success');
            return back();
        }

        flash(trans('messages.price-update-fail'), 'error');
        return back();
    }
}
