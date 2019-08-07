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
              ['field' => 'code', 'name' => 'Código' , 'type' => 'text', 'link' => true],
              ['field' => 'list_name', 'name' => 'Lista de precio' , 'type' => 'text'], 
              ['field' => 'starting_at', 'name' => 'Fecha' , 'type' => 'text']
            ])
            ->setShowState(true)
            ->setReloadOnSave(true)
            ->setShowActions(false)
            ->makeConfig();

        parent::__construct();
    }
}