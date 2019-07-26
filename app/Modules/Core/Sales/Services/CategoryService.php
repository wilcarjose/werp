<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Products\Services\CategoryService as BaseService;
use Werp\Modules\Core\Products\Models\Category;

class CategoryService extends BaseService
{
	protected $type = Category::CUSTOMER_TYPE;
}
