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
        $query = request()->has('q')?request()->get('q'):'';
        $paginate = request()->get('paginate', 15);

        $data = (new CollectionService)
            ->model($this->entityService->getModel())
            ->sort($sort)
            ->query($query)
            ->paginate($paginate)
            ->get();

        //$this->collection::withoutWrapping();

        //return ResponseBuilder::success(new $this->collection($data));
        return new $this->collection($data);
    }
}
