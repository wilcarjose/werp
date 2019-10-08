<?php

namespace Werp\Modules\JMJ\ML\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\JMJ\ML\Builders\UpdatePricesForm;
use Werp\Modules\JMJ\ML\Services\UpdatePricesService;
//use Werp\Modules\JMJ\ML\Transformers\UpdatePricesTransformer;

class UpdatePricesController extends Controller
{
    protected $updatePricesForm;
    protected $updatePricesService;
    protected $updatePricesTransformer;

    public function __construct(
        UpdatePricesForm $updatePricesForm,
        UpdatePricesService $updatePricesService
        //UpdatePricesTransformer $updatePricesTransformer
    ) {
        $this->updatePricesForm        = $updatePricesForm;
        $this->updatePricesService     = $updatePricesService;
        //$this->updatePricesTransformer = $updatePricesTransformer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $updatePrices = []; //$this->updatePricesService->getCompany();

        return $this->updatePricesForm->editPage($updatePrices);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->updatePricesService->updateCompany($request->all());

        flash(trans('messages.success-update'), 'success', 'success');
        return redirect(route('admin.ml.update-prices.edit'));
    }
}
