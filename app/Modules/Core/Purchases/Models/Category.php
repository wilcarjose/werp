<?php

namespace Werp\Modules\Core\Purchases\Models;

use Werp\Modules\Core\Products\Models\Category as CategoryBase;

class Category extends CategoryBase
{
    public function isSupplier()
    {
        return $this->type == CategoryBase::SUPPLIER_TYPE;
    }

    public function isNotSupplier()
    {
        return !$this->isSupplier();
    }
}
