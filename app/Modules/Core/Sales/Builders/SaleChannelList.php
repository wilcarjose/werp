<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Modules\Core\Base\Builders\SimpleBaseList;

class SaleChannelList extends SimpleBaseList
{
    protected $title = 'Canales de ventas';

    protected $route = 'admin.sales.sales_channels';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
    ];

}