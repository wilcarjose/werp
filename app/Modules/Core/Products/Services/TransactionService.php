<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Transaction;
use Werp\Modules\Core\Products\Models\InventoryDetail;

class TransactionService
{
	protected $transaction;
	protected $document;
	protected $stockService;

    public function __construct(Transaction $transaction, StockService $stockService)
    {
    	$this->stockService = $stockService;
        $this->transaction = $transaction;
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

    	$this->transaction->create($data);

    	$stock->add($txQty);
    }
}
