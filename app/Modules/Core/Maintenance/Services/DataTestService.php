<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;

class DataTestService extends BaseService
{

    public function __construct()
    {

    }

    public function updateData()
    {
        $createResult = \Artisan::call('snapshot:create', [
            'name' => 'db-test-dump'
        ]);

        $loadResult = \Artisan::call('snapshot:load', [
            'name' => 'db-test-dump', '--connection' => 'user_tests'
        ]);

        return true;
    }
}