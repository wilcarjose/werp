<?php

namespace Werp\Modules\Core\Purchases\Services;

use Werp\Modules\Core\Purchases\Models\Partner;

class SupplierService
{
	protected $entity;

    public function __construct(Partner $entity)
    {
        $this->entity = $entity;
    }

}
