<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Modules\Core\Base\Builders\SimpleBaseList;

class ExchangeRateList extends SimpleBaseList
{
    protected $title = 'Tasas de cambio';

    protected $route = 'admin.maintenance.exchange_rates';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
        ['field' => 'value', 'name' => 'Valor' , 'type' => 'amount'],
    ];

}