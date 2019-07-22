<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class Order extends Model
{
    const PURCHASE_TYPE = 'PURC';
    const SALE_TYPE = 'SALE';

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'doctype_id',
        'warehouse_id',
        'partner_id',
        'date',
        'type',
        'state',
        'reference',
        'is_invoice_pending',
        'is_delivery_pending',
        'alternate_code'
    ];

    /**
     * Get the detail for the inventory.
     */
    public function detail()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\OrderDetail', 'order_id', 'id');
    }

    /**
     * The inouts that belong to the order.
     */
    public function inouts()
    {
        return $this->belongsToMany('Werp\Modules\Core\Products\Models\Order');
    }

    public function getDetail()
    {
        return $this->detail()->get(); 
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'doctype_id' => $this->doctype_id,
            'warehouse_id' => $this->warehouse_id,
            'date' => $this->date,
            'type' => $this->type,
            'state' => $this->state,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
            'partner_id' => $this->partner_id,
            'is_invoice_pending' => $this->is_invoice_pending,
            'is_delivery_pending' => $this->is_delivery_pending,
            'alternate_code' => $this->alternate_code,
        ];
    }

    public function getType()
    {
        return $this->type == self::PURCHASE_TYPE ? Basedoc::PO_DOC : Basedoc::SO_DOC;
    }

    public function getState($state = null)
    {
        if ($state) {
            return config('products.document.actions.'.$this->getType().'.'.$state);
        }

        return config('products.document.actions.'.$this->getType().'.'.$this->state);
    }
}
