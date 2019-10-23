<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\Main\MainList;

class PriceListTypeList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Listas de precios de ventas')
            ->setRoute('admin.maintenance.price_list_types')
            ->setShowStatus(true)
            ->setFields([
              ['field' => 'name', 'name' => trans('view.name') , 'type' => 'text'],
              ['field' => 'currency_abbr', 'name' => trans('view.currency') , 'type' => 'text']
            ])
            ->makeConfig();

        parent::__construct();
    }
}