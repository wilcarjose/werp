<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Company;

class CompanyService extends BaseService
{
	protected $entity;

    public function __construct(Company $entity)
    {
        $this->entity = $entity;
    }

    public function getCompany()
    {
    	return session('company');
        //return $this->entity->find($id);
    }

    public function updateCompany($data)
    {
        $entity = session('company'); //$this->entity->find($id);

        return $entity->update($data);
    }
}