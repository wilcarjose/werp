<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Base\Services\BaseService;

class CustomerService extends BaseService
{
	protected $entity;

    public function __construct(Partner $entity)
    {
        $this->entity = $entity;
    }

    protected function filters($entity)
    {
    	return $entity->where('is_customer', 'y');
    }

    protected function makeUpdateData($id, $data)
    {
    	$data['is_customer'] = 'y';
    	$data['is_supplier'] = 'n';
        $data['type'] = Partner::CUSTOMER_TYPE;
        return $data;
    }

    protected function makeCreateData($data)
    {
    	$data['is_customer'] = 'y';
        $data['is_supplier'] = 'n';
        $data['type'] = Partner::CUSTOMER_TYPE;

        return $data;
    }

}
