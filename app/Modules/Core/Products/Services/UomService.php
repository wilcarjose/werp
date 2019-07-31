<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Uom;
use Werp\Modules\Core\Base\Services\BaseService;

class UomService extends BaseService
{
    protected $entity;
    
    public function __construct(Uom $entity)
    {
        $this->entity = $entity;
    }
}
