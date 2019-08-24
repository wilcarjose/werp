<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class StockList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Existencia')
            ->setRoute('admin.products.stock')
            ->setShowStatus(false)
            ->setShowActions(false)
            ->setPaginate(false)
            ->setShowAdd(false)
            ->setShowDelete(false)
            ->setFields([
              ['field' => 'code', 'name' => trans('view.code') , 'type' => 'text'],
              ['field' => 'name', 'name' => trans('view.name') , 'type' => 'text'],
              ['field' => 'category', 'name' => trans('view.category') , 'type' => 'text'],
              ['field' => 'warehouse', 'name' => trans('view.products.warehouse') , 'type' => 'text'],
              ['field' => 'qty', 'name' => trans('view.products.qty') , 'type' => 'amount']
            ])
            ->makeConfig();

        parent::__construct();
    }
}