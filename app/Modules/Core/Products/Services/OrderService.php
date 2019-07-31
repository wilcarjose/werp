<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class OrderService extends BaseService
{
    protected $entity;
    protected $inventoryObject;
    protected $transactionService;

    public function __construct(
        Order $entity,
        DoctypeService $doctypeService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->doctypeService       = $doctypeService;
        $this->transactionService   = $transactionService;
    }

    public function process($id)
    {
        $entity = $this->getById($id);

        if ($this->canNotProcess($entity)) {
            throw new CanNotProcessException("No se puede procesar este registro");
        }

        if ($entity->hasNotDetail()) {
            throw new NotDetailException("Debe agregar al menos un producto");
        }

        try {

            $this->transactionService->setDocument($entity)->process();

            $entity->state = Basedoc::PR_STATE;
            $entity->save();

        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request: ".$e->getMessage());
        }
        
    }

    protected function canNotProcess($entity)
    {
        $stateArray = $entity->getState(Basedoc::PR_STATE);

        return !in_array($entity->state, $stateArray['actions_from']);
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

            $newEntity = $this->entity->create($entity->cancelableData());

            foreach ($entity->detail as $detail) {
                $newEntity->detail()->create($detail->cancelableData());
            }

            $entity->state = Basedoc::CA_STATE;
            $entity->reference = $entity->code . '-R';
            $entity->save();

            $this->transactionService->setDocument($newEntity)->process();

        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request: " . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    protected function canNotCancel($entity)
    {
        $stateArray = $entity->getState(Basedoc::CA_STATE);

        return !in_array($entity->state, $stateArray['actions_from']);
    }
}
