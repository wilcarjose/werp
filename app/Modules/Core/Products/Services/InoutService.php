<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Services\BaseService;
use Werp\Modules\Core\Products\Models\Inout;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class InoutService extends BaseService
{
    protected $entity;
    protected $inventoryObject;
    protected $transactionService;

    public function __construct(
        Inout $entity,
        DoctypeService $doctypeService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->doctypeService       = $doctypeService;
        $this->transactionService   = $transactionService;
    }

    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['type'] = Inout::IN_TYPE;
        $data['state'] = Basedoc::PE_STATE;
        return $this->entity->create($data);
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

    protected function makeData($data, $entity = null)
    {
        $data['reference'] = $entity->code;
        $data['date'] = $entity->date;
        $data['currency'] = $entity->currency;
        
        return $data;
    }

    public function getByCode($code)
    {
        return $this->entity->where('code', $code)->first();
    }

    public function reverse($id)
    {
        $entity = $this->getById($id);

        if ($this->canNotReverse($entity)) {
            throw new CanNotReverseException("No se puede reversar este registro");
        }

        try {

            $entity->state = Basedoc::PE_STATE;
            $entity->save();

            //$entity->detail()->update(['status' => 'inactive']);
        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request: ".$e->getMessage());
        }
    }

    protected function canNotReverse($entity)
    {
        $stateArray = $entity->getState(Basedoc::RE_STATE);

        return !in_array($entity->state, $stateArray['actions_from']);
    }
}
