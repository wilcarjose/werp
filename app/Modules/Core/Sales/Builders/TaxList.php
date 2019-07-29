<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Modules\Core\Base\Builders\SimpleBaseList;

class TaxList extends SimpleBaseList
{
    protected $title = 'Impuestos';

    protected $route = 'admin.sales.taxs';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
    ];

}