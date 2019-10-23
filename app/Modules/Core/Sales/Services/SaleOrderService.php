<?php

namespace Werp\Modules\Core\Sales\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Sales\Services\TaxService;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Maintenance\Models\PriceListType;
use Werp\Modules\Core\Products\Models\OrderLine;
use Werp\Modules\Core\Products\Services\OrderService;
use Werp\Modules\Core\Sales\Services\DiscountService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Services\ProductOutputService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
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
    protected $entityLine;

    public function __construct(
        Order $entity,
        TaxService $taxService,
        OrderLine $entityLine,
        DoctypeService $doctypeService,
        DiscountService $discountService,
        ProductOutputService $outputService,
        TransactionService $transactionService
    ) {
        $this->entity             = $entity;
        $this->taxService         = $taxService;
        $this->entityLine       = $entityLine;
        $this->outputService      = $outputService;
        $this->doctypeService     = $doctypeService;
        $this->discountService    = $discountService;
        $this->transactionService = $transactionService;
    }

    protected function filters($entity)
    {
        return $entity->sales();
    }

    public function create(array $data)
    {
        $data['currency_id'] = PriceListType::find($data['price_list_type_id'])->currency_id;
        $data['tax_id'] = isset($data['tax_id']) && $data['tax_id'] ? $data['tax_id'] : null;
        $data['discount_id'] = isset($data['discount_id']) && $data['discount_id'] ? $data['discount_id'] : null;
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
            $data['currency_id'] = PriceListType::find($data['price_list_type_id'])->currency_id;

            $this->entity->where('id', $id)->update($data);

            foreach ($entity->fresh()->lines as $line) {
                $this->updateLineAmounts($line);
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
                    'currency_id' => $entity->currency_id,
                    'partner_id' => $entity->partner_id,
                    'tax_id' => $entity->tax_id,
                    'discount_id' => $entity->discount_id,
                    'order_code' => $entity->code,
                ];

                $output = $this->outputService->create($data);

                $entity->inouts()->attach($output->id);

                foreach ($entity->lines as $line) {

                    $lineData = [
                        'reference' => $output->code,
                        'date' => $line->date,
                        'qty' => $line->qty,
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
                        'currency_id' => $line->currency_id,
                        'order_line_id' => $line->id,
                    ];

                    $outputLine = $output->lines()->create($lineData);

                    $line->qty_delivered = $line->qty;
                    $line->save();
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
