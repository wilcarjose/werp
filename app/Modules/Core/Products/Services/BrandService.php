<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Base\Services\BaseService;

class BrandService extends BaseService
{
    protected $entity;
    
    public function __construct(Brand $entity)
    {
        $this->entity = $entity;
    }
}
