<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\Main\MainList;

class AmountOperationList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Operaciones de montos')
            ->setRoute('admin.maintenance.amount_operations')
            ->setShowStatus(true)
            ->setFields([
              ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
            ])
            ->makeConfig();

        parent::__construct();
    }
}