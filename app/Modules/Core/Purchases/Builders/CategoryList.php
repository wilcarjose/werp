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
}