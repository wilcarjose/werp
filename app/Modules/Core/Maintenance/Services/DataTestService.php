<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;

class DataTestService extends BaseService
{

    public function __construct()
    {

    }

    public function updateData($createDump = true, $name = null)
    {
        $dumpName = $name ?: 'db-test-dump';

        if ($createDump) {
            \Artisan::call('snapshot:create', [
                'name' => $dumpName
            ]);
        }

        return \Artisan::call('snapshot:load', [
            'name' => $dumpName, '--connection' => 'user_tests'
        ]);
    }

    public function updateProductionFromTest()
    {
        \Artisan::call('snapshot:create');

        $dumpName = 'db-test-dump';

        \Artisan::call('snapshot:create', [
            'name' => $dumpName, '--connection' => 'user_tests'
        ]);
        
        return \Artisan::call('snapshot:load', [
            'name' => $dumpName
        ]);
    }
}