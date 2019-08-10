<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Base\Services\BaseService;

class WarehouseService extends BaseService
{
    protected $entity;
    
    public function __construct(Warehouse $entity)
    {
        $this->entity = $entity;
    }
}
