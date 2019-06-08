<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Stock;

class StockService
{
    public function __construct(Stock $category)
    {
        $this->category = $category;
    }
}
