<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Currency;

class CurrencyService extends BaseService
{
	protected $entity;

    public function __construct(Currency $entity)
    {
        $this->entity = $entity;
    }
}