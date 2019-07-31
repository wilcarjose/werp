<?php

namespace Werp\Modules\Core\Products\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Products\Models\Movement;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Products\Models\MovementDetail;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class MovementService extends BaseService
{
    protected $entity;
    protected $doctypeService;
    protected $transactionService;

    public function __construct(
        Movement $entity,
        MovementDetail $entityDetail,
        DoctypeService $doctypeService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->entityDetail         = $entityDetail;
        $this->doctypeService       = $doctypeService;
        $this->transactionService   = $transactionService;
    }

    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
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

            DB::beginTransaction();

            $this->transactionService->setDocument($entity)->process();

            $entity->state = Basedoc::PR_STATE;
            $entity->save();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
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
        $data['warehouse_from_id'] = isset($data['warehouse_from_id']) ?
            $data['warehouse_from_id'] :
            $entity->warehouse_from_id;
        $data['warehouse_to_id'] = isset($data['warehouse_to_id']) ?
            $data['warehouse_to_id'] :
            $entity->warehouse_to_id;
        
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

            $newEntity = $this->entity->create($entity->cancelableData());

            foreach ($entity->detail as $detail) {
                $newEntity->detail()->create($detail->cancelableData());
            }

            $entity->state = Basedoc::CA_STATE;
            $entity->reference = $entity->code . '-R';
            $entity->save();

            $this->transactionService->setDocument($newEntity)->process();

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

    public function createDetail($id, $data)
    {
        $entity = $this->getById($id);

        try {

            DB::beginTransaction();

            $data = $this->makeData($data, $entity);
            $entityDetail = $entity->detail()->create($data);

            DB::commit();

            return $entityDetail;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function updateDetail($data, $detailId)
    {
        $entityDetail = $this->entityDetail->findOrFail($detailId);

        try {

            DB::beginTransaction();

            $data = $this->makeData($data, $entityDetail->movement);
            $entityDetail = $entityDetail->update($data);

            DB::commit();

            return $entityDetail;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function deleteDetail($id, $detailId)
    {
        $entityDetail = $this->entityDetail->findOrFail($detailId);

        try {

            DB::beginTransaction();
    
            $entityDetail->delete();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }
}
