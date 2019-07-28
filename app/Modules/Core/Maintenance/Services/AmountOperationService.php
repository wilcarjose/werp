<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\AmountOperation;

class AmountOperationService extends BaseService
{
	protected $entity;

    public function __construct(AmountOperation $entity)
    {
        $this->entity = $entity;
    }
}