<?php

namespace Werp\Modules\Core\Purchases\Services;

use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Address;

class SupplierService extends BaseService
{
	protected $entity;
    protected $address;

    public function __construct(Partner $entity, Address $address)
    {
        $this->entity = $entity;
        $this->address = $address;
    }

    public function create(array $data)
    {
        try {

            $this->begin();
            
            if (isset($data['address_1'])) {
                $address = $this->address->create([
                    'name'      => 'default',
                    'address_1' => $data['address_1'],
                    'address_2' => $data['address_2'] ?? '',
                ]);

                $data['address_id'] = $address->id;
            }

            $data['is_supplier'] = 'y';
            $data['is_customer'] = 'n';
            $data['type'] = Partner::SUPPLIER_TYPE;

            $supplier = $this->entity->create($data);

            $this->commit();

            return $supplier;

        } catch (\Exception $e) {

            $this->rollback();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function update($id, $data)
    {
        try {

            $this->begin();

            $entity = $this->entity->find($id);

            if (!$entity) {
                return false;
            }

            if (!$entity->address && isset($data['address_1'])) {
                $address = $this->address->create([
                    'name'      => 'default',
                    'address_1' => $data['address_1'],
                    'address_2' => isset($data['address_2']) ? $data['address_2'] : '',
                ]);

                $data['address_id'] = $address->id;
            }

            if ($entity->address  && isset($data['address_1'])) {
                $entity->address->update([
                    'name'      => 'default',
                    'address_1' => $data['address_1'],
                    'address_2' => isset($data['address_2']) ? $data['address_2'] : '',
                ]);
            }

            unset($data['address_1']);
            unset($data['address_2']);

            $this->entity->where('id', $id)->update($data);

            $this->commit();

            return $entity->fresh();

        } catch (\Exception $e) {

            $this->rollback();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }

    }

    protected function filters($entity)
    {
    	return $entity->where('is_supplier', 'y');
    }

    protected function makeUpdateData($id, $data)
    {
    	$data['is_customer'] = 'n';
    	$data['is_supplier'] = 'y';
        $data['type'] = Partner::SUPPLIER_TYPE;
        return $data;
    }

    protected function makeCreateData($data)
    {
    	$data['is_customer'] = 'n';
        $data['is_supplier'] = 'y';
        $data['type'] = Partner::SUPPLIER_TYPE;

        return $data;
    }

}
