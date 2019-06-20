<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;

class InventoryService
{
    protected $inventory;
    protected $inventoryObject;
    protected $transactionService;

    public function __construct(
        Inventory $inventory,
        TransactionService $transactionService
    ) {
        $this->inventory = $inventory;
        $this->transactionService   = $transactionService;
    }

    public function inventoryId(int $id)
    {
        $this->inventoryObject = $this->inventory->find($id);

        return $this;
    }

    public function process()
    {
        if ($this->canNotProcess()) {
            throw new CanNotProcessException("Acción inválida para Inventario procesado");
        }

        try {   

            $this->transactionService->setDocument($this->inventoryObject)->process();

            $this->inventoryObject->state = 'pr';
            $this->inventoryObject->save();

        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request".$e->getMessage());
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
        $stateArray = $this->inventoryObject->getState('pr');

        return !in_array($this->inventoryObject->state, $stateArray['actions_from']);
    }
}
