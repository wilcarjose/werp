<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Price;

class PriceService
{
	protected $price;

    public function __construct(Price $price)
    {
        $this->price = $price;
    }

}
