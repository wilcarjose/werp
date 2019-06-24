<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Modules\Core\Products\Builders\CategoryForm as CategoryFormBase;


class CategoryForm extends CategoryFormBase
{
    protected $moduleRoute = 'admin.purchases.categories';
    protected $listRoute = 'admin.purchases.categories.index';
}