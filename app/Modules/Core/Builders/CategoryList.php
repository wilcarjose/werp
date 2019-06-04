<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Modules\Core\Builders;

use Werp\Builders\Main\MainList;

class CategoryList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Categorias')
            ->setRoute('admin.categories')
            ->setShowStatus(true)
            ->setFields(['name' => 'Nombre'])
            ->makeConfig();

        parent::__construct();
    }
}