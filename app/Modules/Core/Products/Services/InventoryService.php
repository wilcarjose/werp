<?php

namespace Werp\Modules\Core\Products\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Products\Models\InventoryLine;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;

class InventoryService extends BaseService
{
    protected $entity;
    protected $entityLine;
    protected $inventoryObject;
    protected $transactionService;

    public function __construct(
        Inventory $entity,
        InventoryLine $entityLine,
        DoctypeService $doctypeService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->entityLine         = $entityLine;
        $this->doctypeService       = $doctypeService;
        $this->transactionService   = $transactionService;
    }

    public function inventoryId($id)
    {
        $this->inventoryObject = $this->entity->find($id);

        return $this;
    }

    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['state'] = Basedoc::PE_STATE;
        return $this->entity->create($data);
    }

    public function process()
    {
        if ($this->canNotProcess()) {
            throw new CanNotProcessException("Acción inválida para Inventario procesado");
        }

        try {

            $this->begin();

            $this->transactionService->setDocument($this->inventoryObject)->process();

            $this->inventoryObject->state = Basedoc::PR_STATE;
            $this->inventoryObject->save();

            $this->commit();

        } catch (\Exception $e) {

            $this->rollBack();
            throw new \Exception(get_class($e)." Error Processing Request: ".$e->getMessage() . ' File: ' . $e->getFile() . ' Line: ' . $e->getLine());
        }

    }

    public function check()
    {
        if ($this->inventoryObject->getlines()->isEmpty()) {
            throw new NotLinesException("Debe añadir productos al inventario");
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

    public function copy($object)
    {
        $data = array_only($object->toArray(), $object->getCopyable());

        $entity = $this->create($data);

        foreach ($object->lines as $line) {
            $lineData = array_only($line->toArray(), $line->getCopyable());
            $this->createLine($entity->id, $lineData);
        }

        return $entity;
    }
}
