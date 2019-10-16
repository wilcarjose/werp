<?php

namespace Werp\Modules\JMJ\ML\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class PricesExport implements FromArray
{
    protected $prices;

    public function __construct(array $prices)
    {
        $this->prices = $prices;
    }

    public function array(): array
    {
        return $this->prices;
    }
}
