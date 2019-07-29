<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Modules\Core\Base\Builders\SimpleBaseList;

class DiscountList extends SimpleBaseList
{
    protected $title = 'Descuentos';

    protected $route = 'admin.sales.discounts';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
    ];

}