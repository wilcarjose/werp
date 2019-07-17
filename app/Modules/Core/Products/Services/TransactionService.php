<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Transaction;
use Werp\Modules\Core\Products\Models\InventoryDetail;

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

    public function process()
    {
    	if ($this->document->getType() == 'INV') {

    		foreach ($this->document->detail as $detail) {
    			$this->makeTransacion($detail);
    		}
    	}
    }

    protected function makeTransacion(InventoryDetail $detail)
    {
    	$stock = $this->stockService->setProductId($detail->product_id)
    		->setWarehouseId($detail->warehouse_id);
    	
    	$currentQty = $stock->getQty();

    	$sign = $detail->qty < $currentQty ? 'sub' : 'add';
    	$txQty = $detail->qty - $currentQty;

    	$data = [
    		'reference' => $detail->reference,
	        'type' => $detail->inventory->getType(),
	        'date' => $detail->date,
	        'description' => $detail->description,
	        'qty' => $txQty,
	        'sign' => $sign,
	        'product_id' => $detail->product_id,
	        'warehouse_id' => $detail->warehouse_id
    	];

    	$this->entity->create($data);

    	$stock->add($txQty);
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
