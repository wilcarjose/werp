<?php

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\Main\MainList;

class PurchaseOrderList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Ordenes de compras')
            ->setRoute('admin.purchases.orders')
            ->setShowStatus(false)
            ->setFields([
              ['field' => 'code', 'name' => 'Código' , 'type' => 'text'], 
              ['field' => 'date', 'name' => 'Fecha' , 'type' => 'text']
            ])
            ->setShowState(true)
            ->makeConfig();

        parent::__construct();
    }
}