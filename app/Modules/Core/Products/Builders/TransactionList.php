<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class TransactionList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Transacciones')
            ->setRoute('admin.products.transactions')
            ->setShowStatus(false)
            ->setShowActions(false)
            ->setPaginate(false)
            ->setFields([
				['field' => 'code', 'name' => trans('view.code') , 'type' => 'text'],
				['field' => 'name', 'name' => trans('view.name') , 'type' => 'text'],
				['field' => 'date', 'name' => trans('view.date') , 'type' => 'date'],
				//['field' => 'category', 'name' => trans('view.category') , 'type' => 'text'],
				['field' => 'warehouse', 'name' => trans('view.products.warehouse') , 'type' => 'text'],
				['field' => 'qty', 'name' => trans('view.products.qty') , 'type' => 'amount'],
				['field' => 'type', 'name' => trans('view.type') , 'type' => 'text'],
				['field' => 'reference', 'name' => trans('view.reference') , 'type' => 'link'],
				
            ])
            ->makeConfig();

        parent::__construct();
    }
}