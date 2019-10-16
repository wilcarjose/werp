<?php

namespace Werp\Modules\JMJ\ML\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\JMJ\ML\Builders\ConfigForm;
use Werp\Modules\JMJ\ML\Services\AccessService;

class ConfigController extends Controller
{
    protected $configForm;
    protected $accessService;
    protected $configService;

    public function __construct(
        ConfigForm $configForm,
        AccessService $accessService,
        ConfigService $configService
    ) {
        $this->configForm        = $configForm;
        $this->accessService     = $accessService;
        $this->configService     = $configService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param null $priceListId
     * @return Response
     */
    public function edit()
    {
        $id = $this->configService->getValue('ml_app_id');
        $key = $this->configService->getValue('ml_app_key');
        $country = $this->configService->getValue('ml_app_country');
        return $this->configForm->configPage($id, $key, $country);
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
        $rules = [
            'ml_id' => 'required',
            'ml_key' => 'required',
            'ml_country' => 'required',
        ];

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            flash(trans('Ocurrió un error al validar algunos datos'), 'error', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $this->configService->updateOrCreate('ml_app_id', $request->ml_id, 'view.ml.app_id','Mercado Libre ID', 'text', 'ml');
        $this->configService->updateOrCreate('ml_app_key', $request->ml_key, 'view.ml.app_key','Mercado Libre Key', 'text', 'ml');
        $this->configService->updateOrCreate('ml_app_country', $request->ml_country, 'view.ml.app_country','Mercado Libre Country', 'text', 'ml');

        $this->accessService->removeToken();

        flash(trans('messages.config-update'), 'success', 'success');
        return redirect(route('admin.ml.config.edit'));
    }

}
