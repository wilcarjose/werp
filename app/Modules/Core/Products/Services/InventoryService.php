<?php

namespace Werp\Modules\Core\Products\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Products\Models\InventoryDetail;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;

class InventoryService extends BaseService
{
    protected $entity;
    protected $entityDetail;
    protected $inventoryObject;
    protected $transactionService;

    public function __construct(
        Inventory $entity,
        InventoryDetail $entityDetail,
        DoctypeService $doctypeService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->entityDetail         = $entityDetail;
        $this->doctypeService       = $doctypeService;
        $this->transactionService   = $transactionService;
    }

    public function inventoryId(int $id)
    {
        $this->inventoryObject = $this->entity->find($id);

        return $this;
    }

    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        return $this->entity->create($data);
    }

    public function process()
    {
        if ($this->canNotProcess()) {
            throw new CanNotProcessException("Acción inválida para Inventario procesado");
        }

        try {   

            $this->transactionService->setDocument($this->inventoryObject)->process();

            $this->inventoryObject->state = Basedoc::PR_STATE;
            $this->inventoryObject->save();

        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request: ".$e->getMessage());
        }
        
    }

    public function check()
    {
        if ($this->inventoryObject->getDetail()->isEmpty()) {
            throw new NotDetailException("Debe añadir productos al inventario");
        }

        return $this;
    }

    protected function canNotProcess()
    {
        $stateArray = $this->inventoryObject->getState(Basedoc::PR_STATE);

        return !in_array($this->inventoryObject->state, $stateArray['actions_from']);
    }

    protected function makeData($data, $entity = null)
    {
        $data['reference'] = $entity->code;
        $data['warehouse_id'] = isset($data['warehouse_id']) && $data['warehouse_id'] ?
            $data['warehouse_id'] :
            $entity->warehouse_id;
        $data['date'] = $entity->date;
        
        return $data;
    }

    public function getByCode($code)
    {
        return $this->entity->where('code', $code)->first();
    }

    public function cancel($id)
    {
        $entity = $this->getById($id);

        if ($this->canNotCancel($entity)) {
            throw new CanNotProcessException("No se puede anular este registro");
        }

        try {

            DB::beginTransaction();

            $entity->state = Basedoc::CA_STATE;
            $entity->save();

            $this->transactionService->setDocument($entity)->revert();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception("Error Processing Request: " . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    protected function canNotCancel($entity)
    {
        $stateArray = $entity->getState(Basedoc::CA_STATE);

        return !in_array($entity->state, $stateArray['actions_from']);
    }
}
