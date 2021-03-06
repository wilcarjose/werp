<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Maintenance\Builders\DataTestForm;
use Werp\Modules\Core\Maintenance\Services\DataTestService;

class DataTestController extends Controller
{
    protected $dataTestForm;
    protected $dataTestService;

    public function __construct(
        DataTestForm $dataTestForm,
        DataTestService $dataTestService
    ) {
        $this->dataTestForm        = $dataTestForm;
        $this->dataTestService     = $dataTestService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        try {

            return $this->dataTestForm->editPage();

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
    public function update(Request $request)
    {
        try {

            $this->dataTestService->updateData() ?
                flash(trans('messages.success-update'), 'success', 'success') :
                flash(trans('messages.fail-update'), 'error', 'error');

            return redirect(route('admin.maintenance.db_test.edit'));

        } catch (\Exception $e) {
            flash($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine(), 'error', 'error');
            return redirect(route('admin.maintenance.db_test.edit'));
        }
    }

    public function updateFromSql(Request $request) 
    {
        try {

            $rules = [
                'file'  => 'required|file|mimetypes:text/plain',
            ];

            $validator = validator()->make($request->all(), $rules);
        
            if ($validator->fails()) {

                flash(trans('Falló al pasar validaciones'), 'error', 'error');
                return back()->withErrors($validator)->withInput();
            }

            $name = 'sql_loaded';
            $path = \Storage::disk('snapshots')->putFileAs('', $request->file('file'), $name . '.sql');

            $this->dataTestService->updateData(false, $name) ?
                flash(trans('messages.success-update'), 'success', 'success') :
                flash(trans('messages.fail-update'), 'error', 'error');

            return redirect(route('admin.maintenance.db_test.edit'));

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
    public function updateProductionFromTest(Request $request)
    {
        try {

            $this->dataTestService->updateProductionFromTest() ?
                flash(trans('messages.success-update'), 'success', 'success') :
                flash(trans('messages.fail-update'), 'error', 'error');

            return redirect(route('admin.maintenance.db_test.edit'));

        } catch (\Exception $e) {
            flash($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine(), 'error', 'error');
            return redirect(route('admin.maintenance.db_test.edit'));
        }
    }

}
