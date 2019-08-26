<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Services\WarehouseService;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Maintenance\Services\CompanyService;
use Werp\Modules\Core\Maintenance\Builders\InitialConfigForm;

class GeneralConfigController extends Controller
{
    protected $configForm;
    protected $configService;
    protected $companyService;
    protected $warehouseService;
    protected $configTransformer;

    public function __construct(
        InitialConfigForm $configForm,
        ConfigService $configService,
        CompanyService $companyService,
        WarehouseService $warehouseService
    ) {
        $this->configForm        = $configForm;
        $this->configService     = $configService;
        $this->companyService     = $companyService;
        $this->warehouseService     = $warehouseService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $data['company'] = $this->companyService->getCompany()->toArray();
        $data['currencies'] = $this->configService->getCurrencies();
        $data['warehouse'] = $this->warehouseService->getDefaultOrFirst();

        return $this->configForm->editPage($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCompany(Request $request)
    {
        $this->companyService->updateCompany($request->all());

        return redirect(route('admin.maintenance.general_config.edit'));
    }

    public function updateCurrency(Request $request)
    {
        $this->configService->updateConfig($request->all());

        return redirect(route('admin.maintenance.general_config.edit'));
    }

    public function updateWarehouse(Request $request)
    {
    	// si el id existe y diferente de null, busca y actualiza, sino lo crea
        $this->configService->updateConfig($request->all());

        return redirect(route('admin.maintenance.general_config.edit'));
    }
}
