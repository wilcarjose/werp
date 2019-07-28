<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Sales\Models\PaymentMethod;

class PaymentMethodService extends BaseService
{
	protected $entity;

    public function __construct(PaymentMethod $entity)
    {
        $this->entity = $entity;
    }
}
