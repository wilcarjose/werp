<?php

namespace Werp\Modules\JMJ\ML\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Products\Models\Product;

class ItemService extends BaseService
{
	protected $entity;

    public function __construct(Product $product)
    {
        $this->entity = $product;
    }
}
