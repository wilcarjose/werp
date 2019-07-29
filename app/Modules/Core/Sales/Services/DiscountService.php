<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Sales\Models\Discount;
use Werp\Modules\Core\Base\Services\BaseService;

class DiscountService extends BaseService
{
	protected $entity;

    public function __construct(Discount $entity)
    {
        $this->entity = $entity;
    }
}
