<?php

namespace Werp\Modules\Core\Maintenance\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Company;
use Werp\Modules\Core\Maintenance\Models\Address;

class CompanyService extends BaseService
{
	protected $entity;
    protected $address;

    public function __construct(Company $entity, Address $address)
    {
        $this->entity = $entity;
        $this->address = $address;
    }

    public function getCompany()
    {
    	return session('company');
        //return $this->entity->find($id);
    }

    public function updateCompany($data)
    {
        if (isset($data['address_1'])) {
            $address = $this->address->create([
                'name'      => 'default',
                'address_1' => $data['address_1'],
                'address_2' => $data['address_2'] ?? '',
            ]);
        }

        $entity = session('company'); //$this->entity->find($id);

        $entity->addresses()->attach($address->id);

        return $entity->update($data);
    }
}