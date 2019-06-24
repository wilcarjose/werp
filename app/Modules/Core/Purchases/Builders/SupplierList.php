<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\Main\MainList;

class SupplierList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Proveedores')
            ->setRoute('admin.purchases.suppliers')
            ->setShowStatus(true)
            ->setFields(['document' => trans('view.document'), 'name' => trans('view.name'), 'mobile' => trans('view.mobile')])
            ->makeConfig();

        parent::__construct();
    }
}