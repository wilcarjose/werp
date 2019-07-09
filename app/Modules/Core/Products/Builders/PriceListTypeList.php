<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class PriceListTypeList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Tipos de listas de precios')
            ->setRoute('admin.products.price_list_types')
            ->setShowStatus(true)
            ->setFields(['name' => trans('view.name'), 'type' => trans('view.type'), 'currency' => trans('view.currency')])
            ->makeConfig();

        parent::__construct();
    }
}