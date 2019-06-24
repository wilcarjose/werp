<?php

namespace Werp\Modules\Core\Purchases\Services;

use Werp\Modules\Core\Purchases\Models\Supplier;

class SupplierService
{
	protected $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

}
