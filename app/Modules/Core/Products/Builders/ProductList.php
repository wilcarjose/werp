<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class ProductList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Productos')
            ->setRoute('admin.products.products')
            ->setShowStatus(true)
            ->setFields(['name' => 'Nombre', 'description' => 'Descripción', 'category_id' => 'Category'])
            ->makeConfig();

        parent::__construct();
    }
}