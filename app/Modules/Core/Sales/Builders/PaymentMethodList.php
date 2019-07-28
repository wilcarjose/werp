<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Modules\Core\Base\Builders\SimpleBaseList;

class PaymentMethodList extends SimpleBaseList
{
    protected $title = 'Métodos de pagos';

    protected $route = 'admin.sales.payment_methods';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
    ];

}