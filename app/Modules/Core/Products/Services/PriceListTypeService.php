<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Products\Models\PriceListType;

class PriceListTypeService extends BaseService
{
	protected $entity;

    public function __construct(
    	PriceListType $entity
    ) {
        $this->entity = $entity;
    }
}
