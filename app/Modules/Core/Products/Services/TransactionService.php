<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Products\Models\Transaction;
use Werp\Modules\Core\Products\Models\InoutLine;
use Werp\Modules\Core\Products\Models\MovementLine;
use Werp\Modules\Core\Products\Models\InventoryLine;

class TransactionService
{
	protected $entity;
	protected $document;
	protected $stockService;

    public function __construct(Transaction $entity, StockService $stockService)
    {
    	$this->stockService = $stockService;
        $this->entity = $entity;
    }

    public function setDocument($document)
    {
    	$this->document = $document;
    	return $this;
    }

    public function process($document = null)
    {
        if ($document) {
            $this->setDocument($document);
        }

    	if ($this->document->getType() == Basedoc::IN_DOC) {

    		foreach ($this->document->lines as $line) {
    			$this->makeInventory($line);
    		}
    	}

        if ($this->document->getType() == Basedoc::IE_DOC) {

            foreach ($this->document->lines as $line) {
                $this->makeEntry($line);
            }
        }

        if ($this->document->getType() == Basedoc::IO_DOC) {

            foreach ($this->document->lines as $line) {
                $this->makeOutput($line);
            }
        }

        if ($this->document->getType() == Basedoc::IM_DOC) {

            foreach ($this->document->lines as $line) {
                $this->makeMovement($line);
            }
        }
    }

    public function revert($document = null)
    {
        if ($document) {
            $this->setDocument($document);
        }

        if ($this->document->getType() == Basedoc::IN_DOC) {

            foreach ($this->document->lines as $line) {
                $this->revertInventory($line);
            }
        }
    }

    protected function makeInventory(InventoryLine $line)
    {
    	$stock = $this->stockService->setProductId($line->product_id)
    		->setWarehouseId($line->warehouse_id);

    	$currentQty = $stock->getQty();

    	$sign = $line->qty < $currentQty ? 'sub' : 'add';
    	$txQty = $line->qty - $currentQty;

    	$data = [
    		'reference' => $line->reference,
	        'type' => $line->inventory->getType(),
	        'date' => $line->date,
	        'description' => $line->description,
	        'qty' => $txQty,
	        'sign' => $sign,
	        'product_id' => $line->product_id,
	        'warehouse_id' => $line->warehouse_id,
            'process_id' => $line->id,
    	];

    	$this->entity->create($data);

    	$stock->add($txQty);
    }

    protected function makeEntry(InoutLine $line)
    {
        $stock = $this->stockService->setProductId($line->product_id)
            ->setWarehouseId($line->warehouse_id)
            ->add($line->qty);

        $data = [
            'reference' => $line->reference,
            'type' => $line->inout->getType(),
            'date' => $line->date,
            'description' => '',
            'qty' => $line->qty,
            'sign' => 'add',
            'product_id' => $line->product_id,
            'warehouse_id' => $line->warehouse_id,
            'process_id' => $line->id,
        ];

        $this->entity->create($data);
    }

    protected function makeOutput(InoutLine $line)
    {
        $stock = $this->stockService->setProductId($line->product_id)
            ->setWarehouseId($line->warehouse_id)
            ->sub($line->qty);

        $data = [
            'reference' => $line->reference,
            'type' => $line->inout->getType(),
            'date' => $line->date,
            'description' => '',
            'qty' => (-1) * $line->qty,
            'sign' => 'sub',
            'product_id' => $line->product_id,
            'warehouse_id' => $line->warehouse_id,
            'process_id' => $line->id,
        ];

        $this->entity->create($data);
    }

    protected function makeMovement(MovementLine $line)
    {
        // move from
        $this->stockService->setProductId($line->product_id)
            ->setWarehouseId($line->warehouse_from_id)
            ->sub($line->qty);

        $this->entity->create([
            'reference' => $line->reference,
            'type' => $line->movement->getType(),
            'date' => $line->date,
            'description' => '',
            'qty' => (-1) * $line->qty,
            'sign' => 'sub',
            'product_id' => $line->product_id,
            'warehouse_id' => $line->warehouse_from_id,
            'process_id' => $line->id,
        ]);

        // move to
        $this->stockService->setProductId($line->product_id)
            ->setWarehouseId($line->warehouse_to_id)
            ->add($line->qty);

        $this->entity->create([
            'reference' => $line->reference,
            'type' => $line->movement->getType(),
            'date' => $line->date,
            'description' => '',
            'qty' => $line->qty,
            'sign' => 'add',
            'product_id' => $line->product_id,
            'warehouse_id' => $line->warehouse_to_id,
            'process_id' => $line->id,
        ]);

    }

    protected function revertInventory(InventoryLine $line)
    {
        $transaction = $this->entity->where('process_id', $line->id)->firstOrFail();

        $qty = (-1) * $transaction->qty;
        $sign = $qty > 0 ? 'add' : 'sub';

        $data = [
            'reference' => $line->reference,
            'type' => $line->inventory->getType(),
            'date' => $line->date,
            'description' => $line->description,
            'qty' => $qty,
            'sign' => $sign,
            'product_id' => $line->product_id,
            'warehouse_id' => $line->warehouse_id,
            'process_id' => $line->id,
        ];

        $this->stockService->setProductId($line->product_id)
            ->setWarehouseId($line->warehouse_id)
            ->add($qty);

        $this->entity->create($data);
    }

    public function getResults($sort, $order, $search, $paginate)
    {
        $entities = $this->entity->with('warehouse')->with('product')->where(function ($query) use ($search) {
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
}
