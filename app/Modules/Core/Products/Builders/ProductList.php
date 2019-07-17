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
            ->setFields([
              ['field' => 'code', 'name' => trans('view.code') , 'type' => 'text'],
              ['field' => 'name', 'name' => trans('view.name') , 'type' => 'text'],
              ['field' => 'description', 'name' => trans('view.description') , 'type' => 'text']
            ])
            ->makeConfig();

        parent::__construct();
    }
}