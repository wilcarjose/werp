<?php

namespace Werp\Modules\Core\Sales\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Address;

class CustomerService extends BaseService
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

            DB::beginTransaction();
            
            if (isset($data['address_1'])) {
                $address = $this->address->create([
                    'name'      => 'default',
                    'address_1' => $data['address_1'],
                    'address_2' => $data['address_2'],
                ]);

                $data['address_id'] = $address->id;
            }

            $data['is_supplier'] = 'n';
            $data['is_customer'] = 'y';
            $data['type'] = Partner::CUSTOMER_TYPE;

            $customer = $this->entity->create($data);

            DB::commit();

            return $customer;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function update($id, $data)
    {
        try {

            DB::beginTransaction();

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

            DB::commit();

            return $entity->fresh();

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }

    }

    protected function filters($entity)
    {
    	return $entity->where('is_customer', 'y');
    }

    protected function makeUpdateData($id, $data)
    {
    	$data['is_customer'] = 'y';
    	$data['is_supplier'] = 'n';
        $data['type'] = Partner::CUSTOMER_TYPE;
        return $data;
    }

    protected function makeCreateData($data)
    {
    	$data['is_customer'] = 'y';
        $data['is_supplier'] = 'n';
        $data['type'] = Partner::CUSTOMER_TYPE;

        return $data;
    }

}
