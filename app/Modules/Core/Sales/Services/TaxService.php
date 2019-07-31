<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Sales\Models\Tax;
use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Services\AmountOperationService;

class TaxService extends BaseService
{
	protected $entity;
    protected $operationService;

    public function __construct(Tax $entity, AmountOperationService $operationService)
    {
        $this->entity = $entity;
        $this->operationService = $operationService;
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

    public function getTaxAmount($taxId, $amount)
    {
        if (!$taxId) {
            return 0;
        }

        $tax = $this->entity->find($taxId);

        if (!$tax) {
            return 0;
        }

        return $this->operationService->setOperation($tax->operation)->getPercentAmount($amount);
    }
}
