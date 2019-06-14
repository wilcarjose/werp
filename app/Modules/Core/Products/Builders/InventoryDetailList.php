<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class InventoryDetailList extends MainList
{
    public function __construct($empty = false, $filter = null)
    {
        $this->setTitle('Productos')
            ->setRoute('admin.products.inventories')
            ->setShowStatus(false)
            ->setShowSearch(false)
            ->setUseModal(true)
            ->setDeleteMultiple(false)
            ->setShowMessages(false)
            ->setFields(['product_name' => 'Producto', 'qty' => 'Cantidad'])
            ->setFilter($filter)
            ->setEmptyList($empty)
            ->makeConfig();

        parent::__construct();
    }
}