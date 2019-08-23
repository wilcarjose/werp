<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\Core\Maintenance\Builders\CompanyForm;
use Werp\Modules\Core\Maintenance\Services\CompanyService;
use Werp\Modules\Core\Maintenance\Transformers\CompanyTransformer;

class CompanyController extends Controller
{
    protected $companyForm;
    protected $companyService;
    protected $companyTransformer;

    public function __construct(
        CompanyForm $companyForm,
        CompanyService $companyService,
        CompanyTransformer $companyTransformer
    ) {
        $this->companyForm        = $companyForm;
        $this->companyService     = $companyService;
        $this->companyTransformer = $companyTransformer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company = $this->companyService->getCompany();

        return $this->companyForm->editPage($company->toArray());
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
        $this->companyService->updateCompany($request->all());

        flash(trans('messages.success-update'), 'success', 'success');
        return redirect(route('admin.maintenance.company.edit'));
    }
}
