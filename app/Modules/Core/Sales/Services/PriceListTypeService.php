<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Sales\Models\PriceListType;

class PriceListTypeService extends BaseService
{
	protected $entity;

    public function __construct(
    	PriceListType $entity
    ) {
        $this->entity = $entity;
    }
}