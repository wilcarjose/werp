<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Main\MainList;

class CategoryList extends MainList
{
	protected $moduleRoute = 'admin.products.categories';
    protected $listTitle = 'Categorias de Productos';

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