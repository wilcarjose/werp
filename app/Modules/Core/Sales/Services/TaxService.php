<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Sales\Models\Tax;
use Werp\Modules\Core\Base\Services\BaseService;

class TaxService extends BaseService
{
	protected $entity;

    public function __construct(Tax $entity)
    {
        $this->entity = $entity;
    }
}
