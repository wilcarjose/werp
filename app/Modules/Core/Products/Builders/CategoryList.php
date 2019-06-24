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

    public function __construct()
    {
        $this->setTitle('Categorias')
            ->setRoute($this->moduleRoute)
            ->setShowStatus(true)
            ->setFields(['name' => 'Nombre'])
            ->makeConfig();

        parent::__construct();
    }
}