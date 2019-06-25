<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class BrandList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Marcas')
            ->setRoute('admin.products.brands')
            ->setShowStatus(true)
            ->setFields(['name' => trans('view.name')])
            ->makeConfig();

        parent::__construct();
    }
}