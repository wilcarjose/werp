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
        $sort   = request()->has('sort')?request()->get('sort'):'name';
        $order  = request()->has('order')?request()->get('order'):'asc';
        $search = request()->has('searchQuery')?request()->get('searchQuery'):'';
        $paginate = request()->get('paginate', 'on');
        $fields = request()->get('fields', null);

        list($data, $paginator) = $this->entityService->getApiResults($sort, $order, $search, $paginate, $fields);

        //$data = $this->entityTransformer->transformCollection($data);

        return response([
            'data'        => $data,
            'paginator'   => $paginator,
            'status_code' => 200
        ], 200);
    }
}
