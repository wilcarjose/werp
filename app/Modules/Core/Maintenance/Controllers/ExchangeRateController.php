<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Maintenance\Builders\ExchangeRateForm;
use Werp\Modules\Core\Maintenance\Builders\ExchangeRateList;
use Werp\Modules\Core\Maintenance\Services\ExchangeRateService;
use Werp\Modules\Core\Maintenance\Transformers\ExchangeRateTransformer;

class ExchangeRateController extends BaseController
{
    protected $inputs = [
        'currency_from_id',
        'currency_to_id',
        'value',
        'generate_price_list'
    ];

    protected $storeRules = [
        'currency_from_id' => 'required',
        'currency_to_id' => 'required',
        'value' => 'numeric|required',
    ];

    protected $updateRules = [
        'currency_from_id' => 'required',
        'currency_to_id' => 'required',
        'value' => 'numeric|required',
    ];

    protected $routeBase = 'admin.maintenance.exchange_rates';

    public function __construct(
        ExchangeRateForm $entityForm,
        ExchangeRateList $entityList,
        ExchangeRateService $entityService,
        ExchangeRateTransformer $entityTransformer
    ) {
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->entityService     = $entityService;
        $this->entityTransformer = $entityTransformer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loadExchange($currencyFrom, $currencyTo)
    {
        try {

            $entity = $this->entityService->getByName($currencyFrom . '/' . $currencyTo);

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return redirect(route($this->routeBase.'.get', ['currencyFrom' => $entity->currencyFrom->abbr, 'currencyTo' => $entity->currencyTo->abbr]));
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

            $entity = $this->entityService->update($id, $data);

            $entity ?
                flash(trans($this->getUpdatedKey()), 'success', 'success') :
                flash(trans($this->getFailUpdateKey()), 'error', 'error');

            return redirect(route($this->routeBase.'.get', ['currencyFrom' => $entity->currencyFrom->abbr, 'currencyTo' => $entity->currencyTo->abbr]));

        } catch (\Exception $e) {
            flash($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine(), 'error', 'error');
            return $this->goBackTo($request, $id);
        }
    }

}
