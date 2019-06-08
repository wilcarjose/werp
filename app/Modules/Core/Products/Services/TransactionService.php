<?php

namespace Werp\Modules\Core\Products\Services;

use Werp\Modules\Core\Products\Models\Transaction;

class TransactionService
{
    public function __construct(Transaction $category)
    {
        $this->category = $category;
    }
}
