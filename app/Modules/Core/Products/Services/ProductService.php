<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Base\Services\BaseService;

class ProductService extends BaseService
{
	protected $entity;

    public function __construct(
    	Product $entity
    ) {
        $this->entity = $entity;
    }
}
