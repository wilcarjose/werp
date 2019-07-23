<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Products\Models\Uom;

class UomService extends BaseService
{
    protected $entity;
    
    public function __construct(Uom $entity)
    {
        $this->entity = $entity;
    }
}
