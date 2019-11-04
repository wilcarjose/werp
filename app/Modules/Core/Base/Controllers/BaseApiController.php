<?php

namespace Werp\Modules\Core\Base\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Werp\Modules\Core\Base\Services\CollectionService;
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

        $data = (new CollectionService)
            ->model($this->entityService->getModel())
            ->sort($sort, $order)
            ->search($search, $searchFields, false)
            ->paginate($paginate)
            ->get();

        return ResponseBuilder::success(new $this->collection($data));
    }
}
