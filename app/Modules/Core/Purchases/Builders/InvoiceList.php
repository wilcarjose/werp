<?php

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\Main\MainList;

class InvoiceList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Facturas de compras')
            ->setRoute('admin.purchases.invoices')
            ->setShowStatus(false)
            ->setFields([
              ['field' => 'number', 'name' => 'Número' , 'type' => 'text'],
              ['field' => 'date', 'name' => 'Fecha' , 'type' => 'text']
            ])
            ->setShowState(true)
            ->makeConfig();

        parent::__construct();
    }
}
