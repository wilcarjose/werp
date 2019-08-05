<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Sales\Models\TaxDiscount;
use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Services\AmountOperationService;

class DiscountService extends BaseService
{
	protected $entity;
    protected $operationService;

    public function __construct(TaxDiscount $entity, AmountOperationService $operationService)
    {
        $this->entity = $entity;
        $this->operationService = $operationService;
    }

    protected function filters($entity)
    {
    	return $entity->sales()->discounts();
    }

    protected function makeUpdateData($id, $data)
    {
    	$data['type'] = Order::SALE_TYPE;
        $data['is_tax'] = 'n';
        if (isset($data['amount_operation_id']) && !$data['amount_operation_id']) {
            $data['amount_operation_id'] = null;
        }
        return $data;
    }

    protected function makeCreateData($data)
    {
    	$data['type'] = Order::SALE_TYPE;
        $data['is_tax'] = 'n';
        if (isset($data['amount_operation_id']) && !$data['amount_operation_id']) {
            $data['amount_operation_id'] = null;
        }
        return $data;
    }

    public function getDiscountAmount($discountId, $amount)
    {
        if (!$discountId) {
            return 0;
        }

        $discount = $this->entity->find($discountId);

        if (!$discount) {
            return 0;
        }

        return $this->operationService->setOperation($discount->operation)->getPercentAmount($amount);
    }
}
