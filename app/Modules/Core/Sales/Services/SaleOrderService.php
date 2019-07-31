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
        $amountData['amount'] = $price * $qty;
        $amountData['tax_amount'] = $this->taxService->getTaxAmount($taxId, $amountData['amount']);
        $amountData['discount_amount'] = $this->discountService->getDiscountAmount($discountId, $amountData['amount']);
        $amountData['total_amount'] = $amountData['amount'] + $amountData['tax_amount'] - $amountData['discount_amount'];

        return $amountData;
    }

    protected function getTotalAmounts($order)
    {
        $amount = 0;
        $tax_amount = 0;
        $discount_amount = 0;
        $total_amount = 0;

        foreach ($order->detail as $detail) {
            $amount = $amount + $detail->amount;
            $tax_amount = $tax_amount + $detail->tax_amount;
            $discount_amount = $discount_amount + $detail->discount_amount;
            $total_amount = $total_amount + $detail->total_amount;
        }

        return [
            'amount' => $amount,
            'tax_amount' => $tax_amount,
            'discount_amount' => $discount_amount,
            'total_amount' => $total_amount,
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

        $amountData = $this->getAmounts($price->price, $entityDetail->qty, $taxId, $descountId);

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
                    'amount' => $entity->amount,
                    'tax_amount' => $entity->tax_amount,
                    'discount_amount' => $entity->discount_amount,
                    'total_amount' => $entity->total_amount,
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
                        'price' => $detail->price,
                        'product_id' => $detail->product_id,
                        'warehouse_id' => $detail->warehouse_id,
                        'amount' => $detail->amount,
                        'tax_amount' => $detail->tax_amount,
                        'discount_amount' => $detail->discount_amount,
                        'total_amount' => $detail->total_amount,
                        'currency' => $detail->currency,
                        'order_detail_id' => $detail->id,
                    ];
                    
                    $outputDetail = $output->detail()->create($detailData);
                }

                $output->order_code = $entity->code;
                $output->state = Basedoc::PR_STATE;
                $output->save();

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
}