<?php

namespace Werp\Modules\Core\Base\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Base\Exceptions\DeleteRestrictionException;

class BaseApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sort   = request()->has('sort')?request()->get('sort'):'created_at';
        $order  = request()->has('order')?request()->get('order'):'asc';
        $search = request()->has('q')?request()->get('q'):'';
        $searchFields = request()->has('q-fields')?request()->get('q-fields'):'name';
        $paginate = request()->get('paginate', 'on');
        $fields = request()->get('fields', null);

        $data = $this->entityService->getApiResults($sort, $order, $search, $searchFields, $paginate);

        return new $this->collection($data);

        return response([
            'data'        => $data,
            'paginator'   => $paginator,
            'status_code' => 200
        ], 200);
    }
}
