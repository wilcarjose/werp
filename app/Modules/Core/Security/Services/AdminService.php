<?php

namespace Werp\Modules\Core\Security\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Admin;

class AdminService extends BaseService
{
	protected $entity;
    
    public function __construct(Admin $entity)
    {
        $this->entity = $entity;
    }

    public function hasCompany($user)
    {
        return $entity->companies()->isNotEmpty();
    }

    public function hasNotCompany($user)
    {
        return !$this->hasCompany($user);
    }
}