<?php

namespace Werp\Modules\JMJ\ML\Controllers;

use Excel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Werp\Http\Controllers\Controller;
use Werp\Modules\JMJ\ML\Builders\UpdatePricesForm;
use Werp\Modules\JMJ\ML\Exceptions\UpdatePriceException;
use Werp\Modules\JMJ\ML\Exports\PricesExport;
use Werp\Modules\JMJ\ML\Services\AccessService;
use Werp\Modules\JMJ\ML\Services\UpdatePricesService;

class UpdatePricesController extends Controller
{
    protected $updatePricesForm;
    protected $updatePricesService;
    protected $accessService;

    public function __construct(
        UpdatePricesForm $updatePricesForm,
        UpdatePricesService $updatePricesService,
        AccessService $accessService
    ) {
        $this->updatePricesForm        = $updatePricesForm;
        $this->updatePricesService     = $updatePricesService;
        $this->accessService = $accessService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param null $priceListId
     * @return Response
     */
    public function edit($priceListId = null)
    {
        if ($this->accessService->isNotLoggedIn()) {
            return redirect(route('admin.ml.login.view'));
        }

        $prices = $priceListId ? $this->updatePricesService->getPricesByList($priceListId) : [];

        $data = [
            'price_list_type_id' => $priceListId,
            'products' => $prices,
        ];

        return $this->updatePricesForm->editPage($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $priceListId = $request->input('price_list_type_id', null);

        return redirect(route('admin.ml.update-prices.edit', $priceListId));
    }

    public function sendPrices(Request $request)
    {
        $priceListId = $request->input('price_list_type_id', null);
        $prices = $request->input('prices', []);

        if (empty($prices)) {
            flash('No hay productos por actualizar', 'error', 'error');
            return redirect(route('admin.ml.update-prices.edit', $priceListId));
        }

        if (session('ml_access_token', false)) {
            $errors = [];
            foreach ($prices as $code => $price) {
                try {
                    $this->updatePricesService->sendMLPrice($code, $price);
                } catch (UpdatePriceException $e) {
                    $errors[] = $code . ' : ' . $e->getMessage();
                }
            }

            $errorMessage = '';
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $errorMessage .= $error . ', ';
                }
            }

            empty($errorMessage) ?
                flash('Se actualizaron los precios con exito', 'success', 'success') :
                flash('Ocurrió un error al actualizar algunos precios: ' . $errorMessage, 'error', 'error');

            return redirect(route('admin.ml.update-prices.edit', $priceListId));
        }

        $url = $this->accessService->getCallbackUrl();
        return redirect($url);
    }

    public function export($priceListId)
    {
        $prices =  $this->updatePricesService->getPricesByList($priceListId);

        $export = new PricesExport($prices);

        return Excel::download($export, 'prices-'.date('YmdHis').'.xlsx');
    }
}
