<?php

namespace Werp\Modules\Core\Maintenance\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Maintenance\Builders\DataBackupList;
use Werp\Modules\Core\Maintenance\Services\DataBackupService;

class DataBackupController extends Controller
{
    protected $dataBackupList;
    protected $dataBackupService;

    public function __construct(
        DataBackupList $dataBackupList,
        DataBackupService $dataBackupService
    ) {
        $this->dataBackupList        = $dataBackupList;
        $this->dataBackupService     = $dataBackupService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            if (request()->ajax() || request()->wantsJson()) {

                $data = $this->dataBackupService->getBackups();

                $paginator = [
                    'total_count'  => count($data),
                    'total_pages'  => count($data)/10,
                    'current_page' => 2,
                    'limit'        => 10
                ];

                return response([
                    'data'        => $data,
                    'paginator'   => $paginator,
                    'status_code' => 200
                ], 200);
            }

            return $this->dataBackupList->view();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            flash($message, 'error', 'error');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $this->dataBackupService->createBackup();

            flash(trans('messages.success-create'), 'success', 'success');

            return redirect(route('admin.maintenance.db_backups.index'));

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            return redirect(route('admin.maintenance.db_backups.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($date)
    {
        try {

            return $this->dataBackupService->download($date);

        } catch (\Exception $e) {
            flash($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine(), 'error', 'error');
            return redirect(route('admin.maintenance.db_backups.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($date)
    {
        try {

            $this->dataBackupService->drop($date);

            flash(trans('messages.success-delete'), 'success', 'success');

            return redirect(route('admin.maintenance.db_backups.index'));

        } catch (\Exception $e) {
            flash($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine(), 'error', 'error');
            return redirect(route('admin.maintenance.db_backups.index'));
        }
    }
}
