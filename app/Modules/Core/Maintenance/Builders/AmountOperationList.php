<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Modules\Core\Base\Builders\SimpleBaseList;

class AmountOperationList extends SimpleBaseList
{
    protected $title = 'Operaciones de montos';

    protected $route = 'admin.maintenance.amount_operations';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
    ];

}