<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Products\Models\Product;

class ProductService extends BaseService
{
	protected $entity;

    public function __construct(
    	Product $entity
    ) {
        $this->entity = $entity;
    }
}
