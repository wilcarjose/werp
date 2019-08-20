<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Modules\Core\Base\Builders\SimpleBaseList;

class CurrencyList extends SimpleBaseList
{
    protected $title = 'Monedas';

    protected $route = 'admin.maintenance.currencies';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
        ['field' => 'abbr', 'name' => 'Abreviatura' , 'type' => 'text'],
    ];

}