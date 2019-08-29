<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Services\ConfigService;

class WarehouseService extends BaseService
{
    protected $entity;
    protected $configService;
    
    public function __construct(Warehouse $entity, ConfigService $configService)
    {
        $this->entity = $entity;
        $this->configService = $configService;
    }

    public function postCreate($entity)
    {
        session('company')->setComplete('warehouse');
        return $entity;
    }

    public function postUpdate($entity)
    {
        return $entity;
    }

    public function getDefault()
    {
    	$id = $this->configService->getDefaultWarehouse();
    	
    	if (is_null($id)) {
    		return null;
    	}

    	return $this->getActiveById($id);
    }

	public function getFirst()
    {
    	return $this->entity->active()->first();
    }

    public function getDefaultOrFirst()
    {
    	return $this->getDefault() ?: $this->getFirst();
    }
}
