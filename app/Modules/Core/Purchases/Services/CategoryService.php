<?php

namespace Werp\Modules\Core\Purchases\Services;

use Werp\Modules\Core\Products\Services\CategoryService as BaseService;
use Werp\Modules\Core\Purchases\Models\Category;

class CategoryService extends BaseService
{
	protected $type = Category::SUPPLIER_TYPE;
}
