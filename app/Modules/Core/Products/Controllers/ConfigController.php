<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Products\Builders\ConfigForm;
use Werp\Modules\Core\Products\Services\ConfigService;
use Werp\Modules\Core\Products\Transformers\ConfigTransformer;

class ConfigController extends Controller
{
    protected $basedoc;
    protected $warehouse;
    protected $configForm;
    protected $configService;
    protected $configTransformer;

    public function __construct(
        Basedoc $basedoc,
        Warehouse $warehouse,
        ConfigForm $configForm,
        ConfigService $configService,
        ConfigTransformer $configTransformer
    ) {
        $this->basedoc           = $basedoc;
        $this->warehouse           = $warehouse;
        $this->configForm        = $configForm;
        $this->configService     = $configService;
        $this->configTransformer = $configTransformer;
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

        $selects = [
            'doctypes' => $this->basedoc->where('type', 'inv')->first()->doctypes()->get(),
            'warehouses' => $this->warehouse->where('status', 'active')->get(),
        ];

        return $this->configForm->editConfigPage($config, $selects);
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
        return redirect(route('admin.products.config.edit'));
    }
}
