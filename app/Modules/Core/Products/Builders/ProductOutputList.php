<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class ProductOutputList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Salida de productos')
            ->setRoute('admin.products.product_output')
            ->setShowStatus(false)
            ->setFields([
              ['field' => 'code', 'name' => 'Código' , 'type' => 'text'], 
              ['field' => 'date', 'name' => 'Fecha' , 'type' => 'text']
            ])
            ->setShowState(true)
            ->makeConfig();

        parent::__construct();
    }
}