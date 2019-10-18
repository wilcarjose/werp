<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class InoutLine extends Model
{
    protected $table = 'inout_lines';

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
        'currency_id',
        'qty',
        'inout_id',
        'product_id',
        'warehouse_id',
        'order_line_id',
        'discount_id',
        'tax_id',
    ];

    protected $copyable = [
        'reference',
        'date',
        'qty',
        'product_id',
        'warehouse_id',
        'price',
        'tax',
        'discount',
        'full_price',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'currency_id',
        'discount_id',
        'tax_id',
    ];

    protected $cancelable = [
        'reference',
        'date',
        'product_id',
        'warehouse_id',
        'currency_id',
        'order_line_id',
        'discount_id',
        'tax_id',
    ];

    protected $invertible = [
        'qty',
        'price',
        'tax',
        'discount',
        'full_price',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'date' => $this->date,
            'qty' => $this->qty,
            'inout_id' => $this->inout_id,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'price' => $this->price,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'full_price' => $this->full_price,
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
            'currency_id' => $this->currency_id,
            'order_line_id' => $this->order_line_id,
            'tax_id' => $this->tax_id,
            'discount_id' => $this->discount_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function inout()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Inout');
    }

    public function orderLine()
    {
        return $this->hasOne('Werp\Modules\Core\Products\Models\OrderLine', 'id', 'order_line_id');
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

        $data['reference'] = $this->reference . '-R';

        return $data;
    }

    public function getMaster()
    {
        return $this->inout;
    }

    public function product()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Product');
    }

    public function currency()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency');
    }
}
