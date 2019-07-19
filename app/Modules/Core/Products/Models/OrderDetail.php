<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'date',
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'qty',
        'qty_delivered',
        'qty_invoiced',
        'order_id',
        'product_id',
        'warehouse_id'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'date' => $this->date,
            'qty' => $this->qty,
            'qty_delivered' => $this->qty_delivered,
            'qty_invoiced' => $this->qty_invoiced,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'created_at' => $this->created_at,
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
        ];
    }

    public function order()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Order');
    }
}
