<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class PriceListList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Listas de precios')
            ->setRoute('admin.products.price_lists')
            ->setShowStatus(false)
            ->setFields(['code' => 'Código', 'starting_at' => 'Fecha'])
            ->setShowState(true)
            ->makeConfig();

        parent::__construct();
    }
}