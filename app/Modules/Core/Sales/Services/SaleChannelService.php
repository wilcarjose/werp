<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Sales\Models\SaleChannel;
use Werp\Modules\Core\Base\Services\BaseService;

class SaleChannelService extends BaseService
{
	protected $entity;

    public function __construct(SaleChannel $entity)
    {
        $this->entity = $entity;
    }
}
