<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Inventory;

class InventoryService
{
    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }
}
