<?php

namespace Werp\Modules\Core\Purchases\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Products\Services\OrderService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class PurchaseOrderService extends OrderService
{
    public function create(array $data)
    {
        $data['tax_id'] = isset($data['tax_id']) && $data['tax_id'] ? $data['tax_id'] : null;
        $data['discount_id'] = isset($data['discount_id']) && $data['discount_id'] ? $data['discount_id'] : null;
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['type'] = Order::PURCHASE_TYPE;
        $data['state'] = Basedoc::PE_STATE;
        return $this->entity->create($data);
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

            DB::beginTransaction();

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
                    'currency' => $entity->currency,
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
                        'currency' => $detail->currency,
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

            $entity->state = Basedoc::PR_STATE;
            $entity->save();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }
}
