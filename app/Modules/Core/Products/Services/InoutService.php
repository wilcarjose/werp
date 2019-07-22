<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Products\Models\Inout;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Services\PurchaseOrderService;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class InoutService extends BaseService
{
    protected $entity;
    protected $orderService;
    protected $doctypeService;
    protected $transactionService;

    public function __construct(
        Inout $entity,
        DoctypeService $doctypeService,
        PurchaseOrderService $orderService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->orderService         = $orderService;
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

            DB::beginTransaction();

            if ($generateOrder = true) {

                $default = Config::where('key', Config::PRI_DEFAULT_PO_DOC)->first()->value;

                $doctypeId = Doctype::find($default) ?
                    $default :
                    Basedoc::where('type', Basedoc::PO_DOC)->first()->doctypes()->firstOrFail()->id;

                $data = [
                    'description' => $entity->description,
                    'doctype_id' => $doctypeId,
                    'warehouse_id' => $entity->warehouse_id,
                    'date' => $entity->date,
                    'type' => Basedoc::PO_DOC,
                    //'state' => Basedoc::PR_STATE,
                    'amount' => $entity->amount,
                    'tax_amount' => $entity->tax_amount,
                    'discount_amount' => $entity->discount_amount,
                    'total_amount' => $entity->total_amount,
                    'currency' => $entity->currency,
                    'partner_id' => $entity->partner_id,
                    'is_invoice_pending' => 'y',
                    'is_delivery_pending' => 'n',
                ];

                $order = $this->orderService->create($data);
                $order->state = Basedoc::PR_STATE;
                $order->save();
                $entity->orders()->attach($order->id);

                foreach ($entity->detail as $detail) {
                    $detailData = [
                        'reference' => $order->code,
                        'date' => $detail->date,
                        'qty' => $detail->qty,
                        'qty_delivered' => $detail->qty,
                        'qty_invoiced' => 0,
                        'product_id' => $detail->product_id,
                        'warehouse_id' => $detail->warehouse_id,
                        'amount' => $detail->amount,
                        'tax_amount' => $detail->tax_amount,
                        'discount_amount' => $detail->discount_amount,
                        'total_amount' => $detail->total_amount,
                        'currency' => $detail->currency,
                    ];
                    
                    $orderDetail = $order->detail()->create($detailData);

                    $detail->order_detail_id = $orderDetail->id;
                    $detail->save();
                }

                $entity->order_code = $order->code;
            }

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
        $data['currency'] = $entity->currency;
        
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
                $orderDetail = $detail->orderDetail;
                $orderDetail->qty_delivered = $orderDetail->qty_delivered - $detail->qty;
                $orderDetail->save();
                $orderDetail->order->is_delivery_pending = 'y';
                $orderDetail->order->save;
            }

            $entity->state = Basedoc::CA_STATE;
            $entity->reference = $entity->code . '-R';
            $entity->save();

            foreach ($entity->orders as $order) {
                $newEntity->orders()->attach($order->id);
            }

            if ($generateOrder = true) {
                
            }

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
}