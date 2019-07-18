<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;

class InventoryService extends BaseService
{
    protected $entity;
    protected $inventoryObject;
    protected $transactionService;

    public function __construct(
        Inventory $entity,
        DoctypeService $doctypeService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->transactionService   = $transactionService;
        $this->doctypeService       = $doctypeService;
    }

    public function inventoryId(int $id)
    {
        $this->inventoryObject = $this->entity->find($id);

        return $this;
    }

    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['date'] = date('Y-m-d');

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
        $data['date'] = date('Y-m-d');
        
        return $data;
    }

    public function getByCode($code)
    {
        return $this->entity->where('code', $code)->first();
    }
}
