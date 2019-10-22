<?php

namespace Werp\Modules\JMJ\POS\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Services\ConfigService;

class POSService extends BaseService
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService     = $configService;
    }
}
