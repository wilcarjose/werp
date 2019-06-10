<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class InventoryList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Inventarios')
            ->setRoute('admin.products.inventories')
            ->setShowStatus(false)
            ->setFields(['code' => 'Código', 'date' => 'Fecha'])
            ->makeConfig();

        parent::__construct();
    }
}