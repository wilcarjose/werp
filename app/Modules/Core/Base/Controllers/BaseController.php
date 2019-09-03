<?php

namespace Werp\Modules\Core\Base\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Base\Exceptions\DeleteRestrictionException;

class BaseController extends Controller
{
    protected $entityDetail;
    protected $entityTransformer;
    protected $entityDetailTransformer;
    protected $entityForm;
    protected $entityList;
    protected $addedKey = 'messages.success-create';
    protected $updatedKey = 'messages.success-update';
    protected $deleteKey = 'messages.success-delete';
    protected $statusKey = 'messages.update-status';
    protected $notFoundKey = 'messages.resource-not-found';
    protected $failValidationKey = 'messages.parameters-fail-validation';
    protected $failUpdateKey = 'messages.fail-update';
    protected $failCreateKey = 'messages.fail-create';
    protected $inputs = [];
    protected $storeRules = [];
    protected $updateRules = [];
    protected $dependencies = [];
    protected $detailInputs = [];
    protected $storeDetailRules = [];
    protected $updateDetailRules = [];
    protected $relatedField;
    protected $defaultDependencies = [];
    protected $entityService;

    protected function getStoreRules()
    {
        return $this->storeRules;
    }

    protected function getUpdateRules()
    {
        return $this->updateRules;
    }

    protected function getStoreDetailRules()
    {
        return $this->storeDetailRules;
    }

    protected function getUpdateDetailRules()
    {
        return $this->updateDetailRules;
    }

    protected function getInputs()
    {
        return $this->inputs;
    }

    protected function getDetailInputs()
    {
        return $this->detailInputs;
    }

    protected function getAddedKey()
    {
        return $this->addedKey;
    }

    protected function getUpdatedKey()
    {
        return $this->updatedKey;
    }

    protected function getDeleteKey()
    {
        return $this->deleteKey;
    }

    protected function getStatusKey()
    {
        return $this->statusKey;
    }

    protected function getNotFoundKey()
    {
        return $this->notFoundKey;
    }

    protected function getFailValidationKey()
    {
        return $this->failValidationKey;
    }

    protected function getFailUpdateKey()
    {
        return $this->failUpdateKey;
    }

    protected function getFailCreateKey()
    {
        return $this->failCreateKey;
    }

    protected function getDependencies()
    {
        return $this->dependencies;
    }

    protected function setDependencies()
    {
        $this->dependencies = [];
    }

    protected function getRelatedField()
    {
        return $this->relatedField;
    }

    protected function getDefaultsDependencies()
    {
        return $this->defaultDependencies;
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
            $paginate = request()->get('paginate', 'on');

            list($data, $paginator) = $this->entityService->getResults($sort, $order, $search, $paginate);

            if (empty($data)) {
                return response([
                    'status_code' => 404,
                //    'message'     => trans($this->getNotFoundKey())
                ], 404);
            }

            $data = $this->entityTransformer->transformCollection($data);

            return response([
                'data'        => $data,
                'paginator'   => $paginator,
                'status_code' => 200
            ], 200);
        }

        return $this->entityList->view();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            return $this->entityForm->createPage($this->getDependencies(), $this->getDefaultsDependencies());
        
        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());
            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            flash($message, 'error', 'error');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = validator()->make($request->all(), $this->getStoreRules());
        
            if ($validator->fails()) {

                if (request()->ajax() || request()->wantsJson()) {
                    return response([
                        'status_code' => 400,
                        'message'     => trans($this->getFailCreateKey()),
                        'errors'      => $validator->errors()
                    ], 400);
                }

                flash(trans($this->getFailValidationKey()), 'error', 'error');
                return back()->withErrors($validator)->withInput();
            }

            $data = array_only($request->all(), $this->getInputs());

            $entity = $this->entityService->create($data);

            if (request()->ajax() || request()->wantsJson()) {
                return $entity ?
                response([
                    'data'        => $entity->toArray(),
                    'message' => trans($this->getAddedKey()),
                    'status_code' => 200
                ], 200) :
                response([
                    'status_code' => 400,
                    'message'     => trans($this->getFailCreateKey()),
                ], 400);
            }

            $entity ?
                flash(trans($this->getAddedKey()), 'success', 'success') :
                flash(trans($this->getFailCreateKey()), 'error', 'error');

            return $this->goBackTo($request, $entity->id);

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());
            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            flash($message, 'error', 'error');
            return back();
        }
    }

    protected function goBackTo($request, $id)
    {
        if ($request->get('go_back', null) == 'edit' || $request->input('save', null) == 'edit') {
            return redirect(route($this->routeBase.'.edit', $id));
        }

        if ($request->get('go_back', null) == 'new' || $request->input('save', null) == 'new') {
            return redirect(route($this->routeBase.'.create'));
        }

        if ($request->get('go_back', null) == 'list' || $request->input('save', null) == 'list') {
            return redirect(route($this->routeBase.'.index'));
        }

        if ($request->get('go_back', null) == 'home' || $request->input('save', null) == 'home') {
            return redirect(route('admin.home'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   /*
        $entity = $this->entity->find($id);

        if (!$entity) {
            flash(trans('messages.product-not-found'), 'info');
            return back();
        }

        return $this->entityForm->showPage('edit', $entity->toArray());
        */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $entity = $this->entityService->getById($id);

            if (!$entity) {
                flash(trans($this->getNotFoundKey()), 'info');
                return back();
            }

            return $this->entityForm->editPage($entity->toArray(), $this->getDependencies());

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());
            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            flash($message, 'error', 'error');
            return back();
        }
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
        try {

            $validator = validator()->make($request->all(), $this->getUpdateRules());
            
            if ($validator->fails()) {
                flash(trans($this->getFailValidationKey()), 'error', 'error');
                return back()->withErrors($validator)->withInput();
            }

            $data = array_only($request->all(), $this->getInputs());

            $this->entityService->update($id, $data) ?
                flash(trans($this->getUpdatedKey()), 'success', 'success') :
                flash(trans($this->getFailUpdateKey()), 'error', 'error');

            return $this->goBackTo($request, $id);

        } catch (\Exception $e) {
            flash($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine(), 'error', 'error');
            return $this->goBackTo($request, $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            
            $this->entityService->delete($id);
            
            return response([
                'data'        => [],
                'message'     => trans($this->getDeleteKey()),
                'status_code' => 200
            ], 200);

        } catch (DeleteRestrictionException $e) {
            return response([
                'status_code' => 400,
                'message'     => trans('view.texts.associated_to_item'),
            ], 400);

        } catch (\Exception $e) {
            $message = $e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine();
            return response([
                'status_code' => 400,
                'message'     => $message,
            ], 400);
        }
    }

    /**
     * Remove the bulk resource from storage.
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
        try {

            $this->entityService->delete($request->all());

            return response([
                'data'        => [],
                'message'     => trans($this->getDeleteKey()),
                'status_code' => 200
            ], 200);

        } catch (DeleteRestrictionException $e) {
            return response([
                'status_code' => 400,
                'message'     => trans('view.texts.associated_to_item'),
            ], 400);

        } catch (\Exception $e) {
            $message = $e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine();
            return response([
                'status_code' => 400,
                'message'     => $message,
            ], 400);
        }
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
            return response(['error' => trans($this->getFailValidationKey())], 422);
        }

        if ($this->entityService->changeStatus($request->id)) {

            if ($request->wantsJson()) {
                return response([
                    'message'     => trans($this->getStatusKey()),
                    'status_code' => 200
                ], 200);
            }

            flash(trans($this->getStatusKey()),'success', 'success');
            return back();
        }

        flash(trans($this->getFailUpdateKey()), 'error');
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
            return response(['error' => trans($this->getFailValidationKey())], 422);
        }

        if ($this->entityService->changeStatus($request->all())) {
            if ($request->wantsJson()) {
                return response([
                    'message'     => trans($this->getStatusKey()),
                    'status_code' => 200
                ], 200);
            }

            flash(trans($this->getStatusKey()), 'success');
            return back();
        }

        flash(trans($this->getFailUpdateKey()), 'error');
        return back();
    }


    ///// detail
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDetail($id)
    {
        $sort   = request()->has('sort')?request()->get('sort'):'id';
        $order  = request()->has('order')?request()->get('order'):'asc';
        $search = request()->has('searchQuery')?request()->get('searchQuery'):'';

        $entity = $this->entityService->getById($id);
        $detail = $entity->detail;

        $totals = $entity->getTotals();

        $data = $this->entityDetailTransformer
            ->transformCollection($detail->all());
       
        return response([
            'data'        => $data,
            'totals'   => $totals,
            'status_code' => 200
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(Request $request, $id)
    {   
        $validator = validator()->make($request->all(), $this->getStoreDetailRules());
        
        if ($validator->fails()) {
            return response(['error' => trans($this->getFailValidationKey())], 422);
        }

        try {

            $data = array_only($request->all(), $this->getDetailInputs());

            $entityDetail = $this->entityService->createDetail($id, $data);

            $result = $entityDetail instanceof Model ?
                $this->entityDetailTransformer->transform($entityDetail->toArray()) :
                [];

            if ($request->wantsJson()) {
                return response([
                    'data'        => $result,
                    'message'     => trans($this->getUpdatedKey()),
                    'status_code' => 201
                ], 201);
            }
            
            flash(trans($this->getUpdatedKey()), 'success', 'success');
            return back();

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();
        }
        
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
        $validator = validator()->make($request->all(), $this->getUpdateDetailRules());
            
        if ($validator->fails()) {
            return response(['error' => trans($this->getFailValidationKey())], 422);
        }

        try {

            $data = array_only($request->all(), $this->getDetailInputs());

            $entityDetail = $this->entityService->updateDetail($data, $detail);

            $result = $entityDetail instanceof Model ?
                $this->entityDetailTransformer->transform($entityDetail->toArray()) :
                [];

            if ($request->wantsJson()) {
                return response([
                    'data'        => $result,
                    'message'     => trans($this->getUpdatedKey()),
                    'status_code' => 200
                ], 200);
            }
            
            flash(trans($this->getUpdatedKey()), 'success', 'success');
            return back();

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyDetail(Request $request, $id, $detail)
    {
        try {

            $this->entityService->deleteDetail($id, $detail);

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans($this->getDeleteKey()),
                    'status_code' => 200
                ], 200);
            }

            flash(trans($this->getDeleteKey()), 'success', 'success');
            return back();

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();
        }
    }

    /**
     * Remove the bulk resource from storage.
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function destroyDetailBulk(Request $request, $id)
    {
        try {

            $this->entityService->deleteDetail($id, $request->all());

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => trans($this->getDeleteKey()),
                    'status_code' => 200
                ], 200);
            }

            flash(trans($this->getDeleteKey()), 'success', 'success');
            return back();

        } catch (ModelNotFoundException $e) {

            $message = 'Ítem no encontrado, id: '.implode(', ', $e->getIds());

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();

            if ($request->wantsJson()) {
                return response([
                    'data'        => [],
                    'message'     => $message,
                    'status_code' => 400
                ], 400);
            }

            flash($message, 'error', 'error');
            return back();
        }
    }
}
