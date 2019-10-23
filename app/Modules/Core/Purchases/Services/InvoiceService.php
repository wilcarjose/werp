<?php

namespace Werp\Modules\Core\Purchases\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Maintenance\Models\Invoice;
use Werp\Modules\Core\Maintenance\Models\Price;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Sales\Services\TaxService;
use Werp\Modules\Core\Maintenance\Models\InvoiceLine;
use Werp\Modules\Core\Sales\Services\DiscountService;
use Werp\Modules\Core\Maintenance\Services\PriceListService;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;
use Werp\Modules\Core\Products\Services\InoutService;
use Werp\Modules\Core\Maintenance\Services\PriceListTypeService;

class InvoiceService extends BaseService
{
    protected $entity;
    protected $taxService;
    protected $entityLine;
    protected $inoutService;
    protected $configService;
    protected $doctypeService;
    protected $discountService;
    protected $priceListService;
    protected $transactionService;
    protected $priceListTypeService;

    public function __construct(
        Invoice $entity,
        TaxService $taxService,
        InvoiceLine $entityLine,
        InoutService $inoutService,
        ConfigService $configService,
        DoctypeService $doctypeService,
        DiscountService $discountService,
        PriceListService $priceListService,
        TransactionService $transactionService,
        PriceListTypeService $priceListTypeService
    ) {
        $this->entity               = $entity;
        $this->taxService           = $taxService;
        $this->entityLine         = $entityLine;
        $this->inoutService         = $inoutService;
        $this->configService        = $configService;
        $this->doctypeService       = $doctypeService;
        $this->discountService      = $discountService;
        $this->priceListService     = $priceListService;
        $this->transactionService   = $transactionService;
        $this->priceListTypeService = $priceListTypeService;
    }

    public function getlines($lineId)
    {
        return $this->entityLine->findOrFail($lineId);
    }

    public function process($id)
    {
        $entity = $this->getById($id);

        if ($this->canNotProcess($entity)) {
            throw new CanNotProcessException("No se puede procesar este registro");
        }

        if ($entity->hasNotLines()) {
            throw new NotLinesException("Debe agregar al menos un producto");
        }

        try {
            $entity->state = Basedoc::PR_STATE;
            $entity->save();

        } catch (\Exception $e) {
            throw new \Exception("Error Processing Request: ".$e->getMessage());
        }
    }

    protected function makeCreateData($data)
    {
        $data['number'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['price_list_type_id'] = $this->priceListTypeService->getOrCreatePriceList($data['currency_id'], 'purchases')->id;
        $data['type'] = Invoice::PURCHASE_TYPE;
        $data['state'] = Basedoc::PE_STATE;

        return $data;
    }

    protected function canNotProcess($entity)
    {
        $stateArray = $entity->getState(Basedoc::PR_STATE);

        return !in_array($entity->state, $stateArray['actions_from']);
    }

    public function cancel($id)
    {
        $entity = $this->getById($id);

        if ($this->canNotCancel($entity)) {
            throw new CanNotProcessException("No se puede anular este registro");
        }

        try {

            //$newEntity = $this->entity->create($entity->cancelableData());

            //foreach ($entity->lines as $line) {
            //    $newEntity->lines()->create($line->cancelableData());
            //}

            //$entity->state = Basedoc::CA_STATE;
            //$entity->reference = $entity->code . '-R';
            //$entity->save();

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
        $data['reference'] = $entity->number;
        $data['date'] = $entity->date;
        $data['currency_id'] = $entity->currency_id;
        $data['tax_id'] = isset($data['tax_id']) && $data['tax_id'] ? $data['tax_id'] : null;
        $data['discount_id'] = isset($data['discount_id']) && $data['discount_id'] ? $data['discount_id'] : null;

        return $data;
    }

    public function createLine($id, $data)
    {
        $entity = $this->getById($id);

        try {

            DB::beginTransaction();

            $data = $this->makeData($data, $entity);

            $entityLine = $entity->lines()->create($data);

            $this->updateLineAmounts($entityLine, $entity);

            $totalAmountData = $this->getTotalAmounts($entityLine->invoice);

            $entity->update($totalAmountData);

            DB::commit();

            return $entityLine;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function updateLine($data, $lineId)
    {
        try {

            DB::beginTransaction();

            $entityLine = $this->getlines($lineId);

            $entity = $entityLine->invoice;

            $data = $this->makeData($data, $entity);
            $entityLine->update($data);

            $this->updateLineAmounts($entityLine);

            $totalAmountData = $this->getTotalAmounts($entityLine->invoice);

            $entity->update($totalAmountData);

            DB::commit();

            return $entityLine;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function deleteLine($id, $lineId)
    {
        $entity = $this->entity->findOrFail($id);
        $entityLine = $this->getlines($lineId);

        try {

            DB::beginTransaction();

            $entityLine->delete();

            foreach ($entity->fresh()->lines as $line) {
                $this->updateLineAmounts($line);
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
        if ($price instanceof Price) {
            $priceAmount = $price->price;
            $amountData['price_id'] = $price->id;
        } else {
            $priceAmount = $price ?: 0;
        }

        $amountData['price'] = $priceAmount;
        $amountData['tax'] = $this->taxService->getTaxAmount($taxId, $priceAmount);
        $amountData['discount'] = $this->discountService->getDiscountAmount($discountId, $priceAmount);
        $amountData['full_price'] = $priceAmount + $amountData['tax'] - $amountData['discount'];

        $amountData['total_price'] = $priceAmount * $qty;
        $amountData['total_tax'] = $amountData['tax'] * $qty;
        $amountData['total_discount'] = $amountData['discount'] * $qty;
        $amountData['total'] = $amountData['full_price'] * $qty;

        return $amountData;
    }

    protected function getTotalAmounts($invoice)
    {
        $total_price = 0;
        $total_tax = 0;
        $total_discount = 0;
        $total = 0;

        foreach ($invoice->lines as $line) {
            $total_price = $total_price + $line->total_price;
            $total_tax = $total_tax + $line->total_tax;
            $total_discount = $total_discount + $line->total_discount;
            $total = $total + $line->total;
        }

        return [
            'total_price' => $total_price,
            'total_tax' => $total_tax,
            'total_discount' => $total_discount,
            'total' => $total,
        ];
    }

    protected function updateLineAmounts($entityLine, $entity = null)
    {
        if (!$entity) {
            $entity = $entityLine->invoice;
        }

        $price = $entityLine->product->currentPriceObject($entity->price_list_type_id);

        $taxId = $entityLine->tax_id ? $entityLine->tax_id : $entity->tax_id;
        $descountId = $entityLine->discount_id ? $entityLine->discount_id : $entity->discount_id;

        $amountData = $this->getAmounts($price, $entityLine->qty, $taxId, $descountId);

        $entityLine->update($amountData);
    }
}
