<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Sales\Models\PaymentMethod;

class PaymentMethodService extends BaseService
{
	protected $entity;

    public function __construct(PaymentMethod $entity)
    {
        $this->entity = $entity;
    }

    protected function filters($entity)
    {
    	return $entity->where('type', Order::SALE_TYPE);
    }

    protected function makeUpdateData($id, $data)
    {
    	$data['type'] = Order::SALE_TYPE;
        return $data;
    }

    protected function makeCreateData($data)
    {
    	$data['type'] = Order::SALE_TYPE;
        return $data;
    }
}
