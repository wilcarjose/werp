<?php

namespace Werp\Modules\Core\Purchases\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Products\Services\OrderService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class PurchaseOrderService extends OrderService
{
    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['type'] = Order::PURCHASE_TYPE;
        $data['state'] = Basedoc::PR_STATE;
        return $this->entity->create($data);
    }

    protected function makeData($data, $entity = null)
    {
        $data['reference'] = $entity->code;
        $data['date'] = $entity->date;
        $data['currency'] = $entity->currency;
        
        return $data;
    }

}
