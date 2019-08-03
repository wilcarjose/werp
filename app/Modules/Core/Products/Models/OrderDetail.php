<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

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
        'price',
        'tax',
        'discount',
        'full_price',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'currency',
        'qty',
        'qty_delivered',
        'qty_invoiced',
        'order_id',
        'product_id',
        'warehouse_id',
        'tax_id',
        'discount_id',
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
            'tax_id' => $this->tax_id,
            'discount_id' => $this->discount_id,
            'warehouse_id' => $this->warehouse_id,
            'price' => $this->price,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'full_price' => $this->full_price,
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
            'currency' => $this->currency,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function order()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Order');
    }

    public function product()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Product');
    }

    public function getMaster()
    {
        return $this->order;
    }
}
