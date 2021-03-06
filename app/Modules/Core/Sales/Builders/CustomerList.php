<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Main\MainList;

class CustomerList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Clientes')
            ->setRoute('admin.sales.customers')
            ->setShowStatus(true)
            ->setFields([
            	['field' => 'document', 'name' => trans('view.document'), 'type' => 'text'],
            	['field' => 'name', 'name' => trans('view.name'), 'type' => 'text'],
            	['field' => 'mobile', 'name' => trans('view.mobile'), 'type' => 'text'],
            ])
            ->makeConfig();

        parent::__construct();
    }
}