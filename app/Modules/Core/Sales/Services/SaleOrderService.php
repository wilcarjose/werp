<?php

namespace Werp\Modules\Core\Sales\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Sales\Services\TaxService;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Products\Models\OrderDetail;
use Werp\Modules\Core\Products\Services\OrderService;
use Werp\Modules\Core\Sales\Services\DiscountService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Services\ProductOutputService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class SaleOrderService extends OrderService
{
    protected $entity;
    protected $taxService;
    protected $discountService;
    protected $inventoryObject;
    protected $transactionService;
    protected $outputService;

    public function __construct(
        Order $entity,
        TaxService $taxService,
        OrderDetail $entityDetail,
        DoctypeService $doctypeService,
        DiscountService $discountService,
        ProductOutputService $outputService,
        TransactionService $transactionService
    ) {
        $this->entity             = $entity;
        $this->taxService         = $taxService;
        $this->entityDetail       = $entityDetail;
        $this->outputService     = $outputService;
        $this->doctypeService     = $doctypeService;
        $this->discountService    = $discountService;
        $this->transactionService = $transactionService;
    }

    public function getDetail($detailId)
    {
        return $this->entityDetail->findOrFail($detailId);
    }

    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['type'] = Order::SALE_TYPE;
        $data['state'] = Basedoc::PE_STATE;
        return $this->entity->create($data);
    }

    public function update($id, $data)
    {
        try {

            DB::beginTransaction();

            $entity = $this->entity->find($id);

            if (!$entity) {
                return false;
            }

            $data['tax_id'] = isset($data['tax_id']) && $data['tax_id'] ? $data['tax_id'] : null;
            $data['discount_id'] = isset($data['discount_id']) && $data['discount_id'] ? $data['discount_id'] : null;

            $this->entity->where('id', $id)->update($data);

            foreach ($entity->fresh()->detail as $detail) {
                $this->updateDetailAmounts($detail);
            }

            $totalAmountData = $this->getTotalAmounts($entity);

            $entity->update($totalAmountData);

            DB::commit();

            return $entity;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }

    }

    public function createFromInout(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['type'] = Order::SALE_TYPE;
        $data['state'] = Basedoc::PR_STATE;
        return $this->entity->create($data);
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

            if (config('werp.sales_orders.generate_output')) {

                $default = Config::where('key', Config::INV_DEFAULT_IO_DOC)->firstOrFail()->value;

                $doctypeId = Doctype::find($default) ?
                    $default :
                    Basedoc::where('type', Basedoc::IO_DOC)->first()->doctypes()->firstOrFail()->id;

                $data = [
                    'description' => $entity->description,
                    'doctype_id' => $doctypeId,
                    'warehouse_id' => $entity->warehouse_id,
                    'date' => $entity->date,
                    'type' => Basedoc::IO_DOC,
                    'total_price' => $entity->total_price,
                    'total_tax' => $entity->total_tax,
                    'total_discount' => $entity->total_discount,
                    'total' => $entity->total,
                    'currency' => $entity->currency,
                    'partner_id' => $entity->partner_id,
                    'tax_id' => $entity->tax_id,
                    'discount_id' => $entity->discount_id,
                    'order_code' => $entity->code,
                ];

                $output = $this->outputService->create($data);
                
                $entity->inouts()->attach($output->id);

                foreach ($entity->detail as $detail) {

                    $detailData = [
                        'reference' => $output->code,
                        'date' => $detail->date,
                        'qty' => $detail->qty,
                        'product_id' => $detail->product_id,
                        'warehouse_id' => $detail->warehouse_id,
                        'price' => $detail->price,
                        'tax' => $detail->tax,
                        'discount' => $detail->discount,
                        'full_price' => $detail->full_price,
                        'total_price' => $detail->total_price,
                        'total_tax' => $detail->total_tax,
                        'total_discount' => $detail->total_discount,
                        'total' => $detail->total,
                        'currency' => $detail->currency,
                        'order_detail_id' => $detail->id,
                    ];
                    
                    $outputDetail = $output->detail()->create($detailData);

                    $detail->qty_delivered = $detail->qty;
                    $detail->save();
                }

                $output->order_code = $entity->code;
                $output->state = Basedoc::PR_STATE;
                $output->save();

                $this->transactionService->setDocument($output)->process();

                $entity->is_delivery_pending = 'n';
            }

            $entity->state = Basedoc::PR_STATE;
            $entity->save();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
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

            if (config('werp.sales_orders.generate_output')) {            
                foreach ($entity->inouts as $output) {
                    $this->outputService->cancel($output->id);
                }
            }

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