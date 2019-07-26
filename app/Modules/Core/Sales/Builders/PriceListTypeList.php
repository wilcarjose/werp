<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Main\MainList;

class PriceListTypeList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Tipos de listas de precios')
            ->setRoute('admin.sales.price_list_types')
            ->setShowStatus(true)
            ->setFields([
              ['field' => 'name', 'name' => trans('view.name') , 'type' => 'text'],
              ['field' => 'type', 'name' => trans('view.type') , 'type' => 'text'],
              ['field' => 'currency', 'name' => trans('view.currency') , 'type' => 'text']
            ])
            ->makeConfig();

        parent::__construct();
    }
}