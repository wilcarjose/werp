<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Payment extends Model
{
    protected $table = 'branch_offices';

    const DEBIT_CARD = 'debit';
    const CREDIT_CARD = 'credit';

    const PAYMENT_TYPE = 'payment';
    const RECEIPT_TYPE = 'receipt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'transaction_number', 'date', 'description', 'image', 'amount', 'currency_id', 'card_type', 'type', 'state', 'partner_id', 'doctype_id', 'invoice_id', 'bank_id', 'bank_account_id', 'payment_method_id'];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'transaction_number' => $this->transaction_number,
            'date' => $this->date,
            'description' => $this->description,
            'image' => $this->image,
            'company_id' => $this->company_id,
            'amount' => $this->amount,
            'partner_id' => $this->partner_id,
            'currency_id' => $this->currency_id,
            'card_type' => $this->card_type,
            'type' => $this->type,
            'state' => $this->state,
            'doctype_id' => $this->doctype_id,
            'invoice_id' => $this->invoice_id,
            'bank_id' => $this->bank_id,
            'bank_account_id' => $this->bank_account_id,
            'payment_method_id' => $this->payment_method_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function bank()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\Bank');
    }
}
