<?php

namespace Werp\Modules\Core\Products\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Products\Models\Inout;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Products\Models\InoutLine;
//use Werp\Modules\Core\Sales\Services\SaleOrderService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Exceptions\CanNotReverseException;

class ProductOutputService extends BaseService
{
    protected $entity;
    protected $orderService;
    protected $doctypeService;
    protected $transactionService;

    public function __construct(
        Inout $entity,
        InoutLine $entityLine,
        DoctypeService $doctypeService,
        //SaleOrderService $orderService,
        TransactionService $transactionService
    ) {
        $this->entity               = $entity;
        $this->entityLine         = $entityLine;
        //$this->orderService         = $orderService;
        $this->doctypeService       = $doctypeService;
        $this->transactionService   = $transactionService;
    }

    public function create(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        $data['type'] = Inout::OUT_TYPE;
        $data['state'] = Basedoc::PE_STATE;
        return $this->entity->create($data);
    }

    public function getResults($sort, $order, $search, $paginate)
    {
        $entities = $this->entity
            ->where('type', Inout::OUT_TYPE)
            ->where(function ($query) use ($search) {
                //if ($search) {
                //    $query->where('name', 'like', "$search%");
                //}
            })
            ->orderBy("$sort", "$order");

        $total = $entities->count();

        if ($total <= 0) {
            return [];
        }

        $entities = $paginate == 'off' ? $entities : $entities->paginate(10);

        $paginator = $paginate == 'off' ? [
                'total_count'  => $total,
                'total_pages'  => 1,
                'current_page' => 1,
                'limit'        => $total
            ] : [
                'total_count'  => $entities->total(),
                'total_pages'  => $entities->lastPage(),
                'current_page' => $entities->currentPage(),
                'limit'        => $entities->perPage()
            ];

        $data = $paginate == 'off' ? $entities->get()->toArray() : $entities->all();

        return [$data, $paginator];
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

            DB::beginTransaction();

            if ($generateOrder = false) {

                $default = Config::where('key', Config::INV_DEFAULT_SO_DOC)->first()->value;

                $doctypeId = Doctype::find($default) ?
                    $default :
                    Basedoc::where('type', Basedoc::SO_DOC)->first()->doctypes()->firstOrFail()->id;

                $data = [
                    'description' => $entity->description,
                    'doctype_id' => $doctypeId,
                    'warehouse_id' => $entity->warehouse_id,
                    'date' => $entity->date,
                    'type' => Basedoc::SO_DOC,
                    'total_price' => $entity->total_price,
                    'total_tax' => $entity->total_tax,
                    'total_discount' => $entity->total_discount,
                    'total' => $entity->total,
                    'currency' => $entity->currency,
                    'partner_id' => $entity->partner_id,
                    'is_invoice_pending' => 'y',
                    'is_delivery_pending' => 'n',
                ];

                $order = $this->orderService->create($data);
                $order->state = Basedoc::PR_STATE;
                $order->save();
                $entity->orders()->attach($order->id);

                foreach ($entity->lines as $line) {

                    $lineData = [
                        'reference' => $order->code,
                        'date' => $line->date,
                        'qty' => $line->qty,
                        'qty_delivered' => $line->qty,
                        'qty_invoiced' => 0,
                        'product_id' => $line->product_id,
                        'warehouse_id' => $line->warehouse_id,
                        'price' => $line->price,
                        'tax' => $line->tax,
                        'discount' => $line->discount,
                        'full_price' => $line->full_price,
                        'total_price' => $line->total_price,
                        'total_tax' => $line->total_tax,
                        'total_discount' => $line->total_discount,
                        'total' => $line->total,
                        'currency' => $line->currency,
                    ];

                    $orderLine = $order->lines()->create($lineData);

                    $line->order_line_id = $orderLine->id;
                    $line->save();
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
        $data['date'] = $entity->date;
        $data['warehouse_id'] = isset($data['warehouse_id']) && $data['warehouse_id'] ?
            $data['warehouse_id'] :
            $entity->warehouse_id;

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

            foreach ($entity->lines as $line) {
                $newEntity->lines()->create($line->cancelableData());
                $orderLine = $line->orderLine;
                $orderLine->qty_delivered = $orderLine->qty_delivered - $line->qty;
                $orderLine->save();
                $orderLine->order->is_delivery_pending = 'y';
                $orderLine->order->save();
            }

            $entity->state = Basedoc::CA_STATE;
            $entity->reference = $entity->code . '-R';
            $entity->save();

            foreach ($entity->orders as $order) {
                $newEntity->orders()->attach($order->id);
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

    public function createLine($id, $data)
    {
        $entity = $this->getById($id);

        try {

            DB::beginTransaction();

            $data = $this->makeData($data, $entity);

            $data['discount'] = 0;
            $data['tax'] = 0;
            $data['full_price'] = $data['price'] + $data['tax'] + $data['discount'];
            $data['total_price'] = $data['price'] * $data['qty'];
            $data['total_discount'] = $data['discount'] * $data['qty'];
            $data['total_tax'] = $data['tax'] * $data['qty'];
            $data['total'] = $data['full_price'] * $data['qty'];

            $entityLine = $entity->lines()->create($data);

            $total_price = 0;
            $total_tax = 0;
            $total_discount = 0;
            $total = 0;

            foreach ($entity->lines as $line) {
                $total_price = $total_price + $line->total_price;
                $total_tax = $total_tax + $line->total_tax;
                $total_discount = $total_discount + $line->total_discount;
                $total = $total + $line->total;
            }

            $entity->update([
                'total_price' => $total_price,
                'total_tax' => $total_tax,
                'total_discount' => $total_discount,
                'total' => $total,
            ]);

            DB::commit();

            return $entityLine;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function updateLine($data, $lineId)
    {
        $entityLine = $this->entityLine->findOrFail($lineId);

        try {

            DB::beginTransaction();

            $data['discount'] = 0;
            $data['tax'] = 0;
            $data['full_price'] = $data['price'] + $data['tax'] + $data['discount'];
            $data['total_price'] = $data['price'] * $data['qty'];
            $data['total_discount'] = $data['discount'] * $data['qty'];
            $data['total_tax'] = $data['tax'] * $data['qty'];
            $data['total'] = $data['full_price'] * $data['qty'];

            $entityLine->update($data);

            $total_price = 0;
            $total_tax = 0;
            $total_discount = 0;
            $total = 0;

            foreach ($entityLine->inout->lines as $line) {
                $total_price = $total_price + $line->total_price;
                $total_tax = $total_tax + $line->total_tax;
                $total_discount = $total_discount + $line->total_discount;
                $total = $total + $line->total;
            }

            $entityLine->inout->update([
                'total_price' => $total_price,
                'total_tax' => $total_tax,
                'total_discount' => $total_discount,
                'total' => $total,
            ]);

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
        $entityLine = $this->entityLine->findOrFail($lineId);

        try {

            DB::beginTransaction();

            $entityLine->delete();

            $total_price = 0;
            $total_tax = 0;
            $total_discount = 0;
            $total = 0;

            foreach ($entity->lines as $line) {
                $total_price = $total_price + $line->total_price;
                $total_tax = $total_tax + $line->total_tax;
                $total_discount = $total_discount + $line->total_discount;
                $total = $total + $line->total;
            }

            $entity->update([
                'total_price' => $total_price,
                'total_tax' => $total_tax,
                'total_discount' => $total_discount,
                'total' => $total,
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }
}
