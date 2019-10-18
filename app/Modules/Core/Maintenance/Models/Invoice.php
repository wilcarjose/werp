<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Invoice extends Model
{
    const PURCHASE_TYPE = 'PURC';
    const SALE_TYPE = 'SALE';

    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'control_number',
        'order_code',
        'date',
        'description',
        'alter_code',
        'reference',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'currency_id',
        'type',
        'partner_id',
        'doctype_id',
        'price_list_type_id',
        'order_id',
        'tax_id',
        'discount_id',
        'company_id',
        'payment_method_id',
        'state'
    ];

    protected $copyable = [
    ];

    protected $cancelable = [
    ];

    protected $invertible = [
        'total_price',
        'total_tax',
        'total_discount',
        'total',
    ];

    /**
     * Get the lines for the inventory.
     */
    public function lines()
    {
        return $this->hasMany('Werp\Modules\Core\Maintenance\Models\InvoiceLine', 'invoice_id', 'id');
    }

    public function getTotals()
    {
        return [
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
        ];
    }

    /**
     * The orders that belong to the inout.
     */
    public function orders()
    {
        return $this->belongsToMany('Werp\Modules\Core\Products\Models\Order');
    }

    public function getlines()
    {
        return $this->lines()->get();
    }

    public function hasLines()
    {
        return $this->lines()->count() > 0;
    }

    public function hasNotLines()
    {
        return !$this->hasLines();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'control_number' => $this->control_number,
            'order_code' => $this->order_code,
            'date' => $this->date,
            'description' => $this->description,
            'alter_code' => $this->alter_code,
            'reference' => $this->reference,
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
            'currency_id' => $this->currency_id,
            'type' => $this->type,
            'partner_id' => $this->partner_id,
            'doctype_id' => $this->doctype_id,
            'price_list_type_id' => $this->price_list_type_id,
            'order_id' => $this->order_id,
            'tax_id' => $this->tax_id,
            'discount_id' => $this->discount_id,
            'company_id' => $this->company_id,
            'payment_method_id' => $this->payment_method_id,
            'state' => $this->state,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function cancelableData()
    {
        $data = [];

        foreach ($this->cancelable as $cancel) {
            $data[$cancel] = $this->toArray()[$cancel];
        }

        foreach ($this->invertible as $invert) {
            $data[$invert] = (-1) * $this->toArray()[$invert];
        }

        //$data['code'] = $this->code . '-R';
        //$data['reference'] = $this->code;
        //$data['state'] = Basedoc::CA_STATE;

        return $data;
    }

    public function getType()
    {
        return $this->type == self::SALE_TYPE ? Basedoc::SI_DOC : Basedoc::PI_DOC;
    }

    public function getState($state = null)
    {
        if ($state) {
            return config('purchases.document.actions.'.$this->getType().'.'.$state);
        }

        return config('purchases.document.actions.'.$this->getType().'.'.$this->state);
    }

    public function partner()
    {
        return $this->belongsTo('Werp\Modules\Core\Purchases\Models\Partner');
    }

    public function currency()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency');
    }

    public function order()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Order');
    }
}
