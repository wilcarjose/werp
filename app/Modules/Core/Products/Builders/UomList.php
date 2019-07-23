<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class UomList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Unidad de medida')
            ->setRoute('admin.products.uom')
            ->setShowStatus(true)
            ->setFields([
              ['field' => 'name', 'name' => trans('view.name') , 'type' => 'text'],
              ['field' => 'abbr', 'name' => trans('view.abbr') , 'type' => 'text']
            ])
            ->makeConfig();

        parent::__construct();
    }
}