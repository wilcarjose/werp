<?php

namespace Werp\Modules\Core\Products\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Sales\Services\TaxService;
use Werp\Modules\Core\Products\Models\OrderDetail;
use Werp\Modules\Core\Sales\Services\DiscountService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;
use Werp\Modules\Core\Products\Services\InoutService;

class OrderService extends BaseService
{
    protected $entity;
    protected $inventoryObject;
    protected $transactionService;
    protected $taxService;
    protected $discountService;
    protected $entityDetail;
    protected $inoutService;


    public function __construct(
        Order $entity,
        TaxService $taxService,
        OrderDetail $entityDetail,
        InoutService $inoutService,
        DoctypeService $doctypeService,
        DiscountService $discountService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->taxService           = $taxService;
        $this->discountService      = $discountService;
        $this->doctypeService       = $doctypeService;
        $this->entityDetail         = $entityDetail;
        $this->transactionService   = $transactionService;
        $this->inoutService   = $inoutService;
    }

    public function getDetail($detailId)
    {
        return $this->entityDetail->findOrFail($detailId);
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

    protected function makeData($data, $entity = null)
    {
        $data['reference'] = $entity->code;
        $data['date'] = $entity->date;
        $data['currency'] = $entity->currency;
        $data['warehouse_id'] = isset($data['warehouse_id']) ? $data['warehouse_id'] : $entity->warehouse_id;
        $data['tax_id'] = isset($data['tax_id']) && $data['tax_id'] ? $data['tax_id'] : null;
        $data['discount_id'] = isset($data['discount_id']) && $data['discount_id'] ? $data['discount_id'] : null;
        $data['qty_delivered'] = 0;
        $data['qty_invoiced'] = 0;
        
        return $data;
    }

    public function createDetail($id, $data)
    {
        $entity = $this->getById($id);

        try {

            DB::beginTransaction();

            $data = $this->makeData($data, $entity);

            $entityDetail = $entity->detail()->create($data);

            $this->updateDetailAmounts($entityDetail, $entity);

            $totalAmountData = $this->getTotalAmounts($entityDetail->order);

            $entity->update($totalAmountData);

            DB::commit();

            return $entityDetail;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function updateDetail($data, $detailId)
    {
        try {

            DB::beginTransaction();

            $entityDetail = $this->getDetail($detailId);

            $entity = $entityDetail->order;

            $data = $this->makeData($data, $entity);
            $entityDetail->update($data);

            $this->updateDetailAmounts($entityDetail);

            $totalAmountData = $this->getTotalAmounts($entityDetail->order);

            $entity->update($totalAmountData);

            DB::commit();

            return $entityDetail;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function deleteDetail($id, $detailId)
    {
        $entity = $this->entity->findOrFail($id);
        $entityDetail = $this->getDetail($detailId);

        try {

            DB::beginTransaction();
    
            $entityDetail->delete();

            foreach ($entity->fresh()->detail as $detail) {
                $this->updateDetailAmounts($detail);
            }

            $totalAmountData = $this->getTotalAmounts($entity);

            $entity->update($totalAmountData);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    protected function getAmounts($price, $qty, $taxId, $discountId)
    {
        $amountData['price'] = $price;
        $amountData['tax'] = $this->taxService->getTaxAmount($taxId, $price);
        $amountData['discount'] = $this->discountService->getDiscountAmount($discountId, $price);
        $amountData['full_price'] = $price + $amountData['tax'] - $amountData['discount'];

        $amountData['total_price'] = $price * $qty;
        $amountData['total_tax'] = $amountData['tax'] * $qty;
        $amountData['total_discount'] = $amountData['discount'] * $qty;
        $amountData['total'] = $amountData['full_price'] * $qty;

        return $amountData;
    }

    protected function getTotalAmounts($order)
    {
        $total_price = 0;
        $total_tax = 0;
        $total_discount = 0;
        $total = 0;

        foreach ($order->detail as $detail) {
            $total_price = $total_price + $detail->total_price;
            $total_tax = $total_tax + $detail->total_tax;
            $total_discount = $total_discount + $detail->total_discount;
            $total = $total + $detail->total;
        }

        return [
            'total_price' => $total_price,
            'total_tax' => $total_tax,
            'total_discount' => $total_discount,
            'total' => $total,
        ];
    }

    protected function updateDetailAmounts($entityDetail, $entity = null)
    {
        if (!$entity) {
            $entity = $entityDetail->order;
        }

        $price = $entityDetail->product->currentPrice($entity->price_list_type_id);

        $taxId = $entityDetail->tax_id ? $entityDetail->tax_id : $entity->tax_id;
        $descountId = $entityDetail->discount_id ? $entityDetail->discount_id : $entity->discount_id;

        $amountData = $this->getAmounts($price, $entityDetail->qty, $taxId, $descountId);

        $entityDetail->update($amountData);
    }
}
