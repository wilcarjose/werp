<?php

namespace Werp\Modules\Core\Purchases\Services;

use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Sales\Models\PriceListType;
use Werp\Modules\Core\Products\Services\OrderService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class PurchaseOrderService extends OrderService
{
    protected function filters($entity)
    {
        return $entity->purchases();
    }

    protected function makeUpdateData($id, $data)
    {
        $data['price_list_type_id'] = $this->priceListTypeService->getOrCreatePriceList($data['currency_id'], 'purchases')->id;

        return $data;
    }

    protected function makeCreateData($data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['price_list_type_id'] = $this->priceListTypeService->getOrCreatePriceList($data['currency_id'], 'purchases')->id;
        $data['type'] = Order::PURCHASE_TYPE;
        $data['state'] = Basedoc::PE_STATE;

        return $data;
    }

    protected function updateDetailAmounts($entityDetail, $entity = null)
    {
        if (!$entity) {
            $entity = $entityDetail->order;
        }

        $taxId = $entityDetail->tax_id ? $entityDetail->tax_id : $entity->tax_id;
        $descountId = $entityDetail->discount_id ? $entityDetail->discount_id : $entity->discount_id;

        $amountData = $this->getAmounts($entityDetail->price, $entityDetail->qty, $taxId, $descountId);

        $entityDetail->update($amountData);
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

            $this->begin();

            if (config('werp.purchases_orders.generate_entry')) {

                $default = Config::where('key', Config::INV_DEFAULT_IE_DOC)->firstOrFail()->value;

                $doctypeId = Doctype::find($default) ?
                    $default :
                    Basedoc::where('type', Basedoc::IE_DOC)->first()->doctypes()->firstOrFail()->id;

                $data = [
                    'description' => $entity->description,
                    'doctype_id' => $doctypeId,
                    'warehouse_id' => $entity->warehouse_id,
                    'date' => $entity->date,
                    'type' => Basedoc::IE_DOC,
                    'total_price' => $entity->total_price,
                    'total_tax' => $entity->total_tax,
                    'total_discount' => $entity->total_discount,
                    'total' => $entity->total,
                    'currency_id' => $entity->currency_id,
                    'partner_id' => $entity->partner_id,
                    'tax_id' => $entity->tax_id,
                    'discount_id' => $entity->discount_id,
                    'order_code' => $entity->code,
                ];

                $entry = $this->inoutService->create($data);
                
                $entity->inouts()->attach($entry->id);

                foreach ($entity->detail as $detail) {

                    $detailData = [
                        'reference' => $entry->code,
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
                        'currency_id' => $detail->currency_id,
                        'order_detail_id' => $detail->id,
                    ];
                    
                    $entryDetail = $entry->detail()->create($detailData);

                    $detail->qty_delivered = $detail->qty;
                    $detail->save();
                }

                $entry->order_code = $entity->code;
                $entry->state = Basedoc::PR_STATE;
                $entry->save();

                $this->transactionService->setDocument($entry)->process();

                $entity->is_delivery_pending = 'n';
            }

            if (config('werp.purchases_orders.generate_price_list')) {

                $priceList = $this->priceListService->createPriceList([
                    'description' => 'Generada automáticamente desde orden de compra # '.$entity->code,
                    'starting_at' => $entity->date,
                    'price_list_type_id' => $this->priceListTypeService->getOrCreatePriceList($entity->currency_id, 'purchases')->id,
                    'doctype_id' => $this->configService->getDefaultInventaryDoctype(),
                ]);

                foreach ($entity->detail as $detail) {
                    // check if is full_price or price
                    $price = $this->priceListService->createPrice($priceList, $detail->product, $detail->full_price, true);

                    $detail->price_id = $price->id;
                    $detail->save();
                }

                $this->priceListService->process($priceList->id);
            }

            $entity->state = Basedoc::PR_STATE;
            $entity->save();

            $this->commit();

        } catch (\Exception $e) {

            $this->rollback();
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

            $this->begin();

            $entity->state = Basedoc::CA_STATE;
            $entity->save();

            if (config('werp.purchases_orders.generate_entry')) {
                foreach ($entity->inouts as $output) {
                    $this->inoutService->cancel($output->id);
                }
            }

            $this->commit();

        } catch (\Exception $e) {

            $this->rollback();
            throw new \Exception("Error Processing Request: " . $e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }
}
