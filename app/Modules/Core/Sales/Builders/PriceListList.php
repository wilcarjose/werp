<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Main\MainList;

class PriceListList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Listas de precios')
            ->setRoute('admin.sales.price_lists')
            ->setShowStatus(false)
            ->setFields([
              ['field' => 'code', 'name' => 'Código' , 'type' => 'text'], 
              ['field' => 'starting_at', 'name' => 'Fecha' , 'type' => 'text']
            ])
            ->setShowState(true)
            ->makeConfig();

        parent::__construct();
    }
}