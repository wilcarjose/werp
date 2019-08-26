<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Maintenance\Builders\ConfigForm;
use Werp\Modules\Core\Maintenance\Services\ConfigService;

class ConfigController extends Controller
{
    protected $configForm;
    protected $configService;

    public function __construct(
        ConfigForm $configForm,
        ConfigService $configService
    ) {
        $this->configForm        = $configForm;
        $this->configService     = $configService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $config = $this->configService->getConfig();

        return $this->configForm->configPage($config);
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
        $this->configService->updateConfig($request->all());

        flash(trans('messages.config-update'), 'success', 'success');
        return redirect(route('admin.maintenance.config.edit'));
    }
}
