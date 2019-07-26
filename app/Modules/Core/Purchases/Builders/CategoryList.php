<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Modules\Core\Products\Builders\CategoryList as CategoryListBase;

class CategoryList extends CategoryListBase
{
	protected $moduleRoute = 'admin.purchases.categories';
    protected $listTitle = 'Categorias de Proveedores';

    public function __construct()
    {
        $this->setTitle($this->listTitle)
            ->setRoute($this->moduleRoute)
            ->setShowStatus(true)
            ->setFields([
              ['field' => 'name', 'name' => trans('view.name') , 'type' => 'text']
            ])
            ->makeConfig();

        parent::__construct();
    }
}