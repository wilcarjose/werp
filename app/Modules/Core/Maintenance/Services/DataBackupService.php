<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;

class DataBackupService extends BaseService
{
    protected $extension = '.sql';

    public function getBackups()
    {
        $files = \Storage::disk('snapshots')->files();

        $data = [];

        foreach ($files as $file) {

            $fileName = str_replace('.sql', '', $file);

            if ($fileName == 'db-test-dump') {
                continue;
            }

            $data[] = [
                'id' => $fileName,
                'name' => $fileName,
            ];
        }

        usort($data, function ($item1, $item2) {
            return $item2['id'] <=> $item1['id'];
        });

        return $data;
    }

    public function createBackup()
    {
        return \Artisan::call('snapshot:create');
    }

    public function download($name)
    {
        return \Storage::disk('snapshots')->download($name.$this->extension);
    }

    public function drop($name)
    {
        return \Storage::disk('snapshots')->delete($name.$this->extension);
    }
}