<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class PriceList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Listas de precios')
            ->setRoute('admin.products.prices')
            ->setShowStatus(true)
            ->setFields(['name' => 'Nombre'])
            ->setShowState(false)
            ->makeConfig();

        parent::__construct();
    }
}