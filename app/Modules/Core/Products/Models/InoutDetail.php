<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class InoutDetail extends Model
{
    protected $table = 'inout_detail';

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
        'inout_id',
        'product_id',
        'warehouse_id',
        'order_detail_id'
    ];

    protected $copyable = [
        'reference',
        'date',
        'qty',
        'product_id',
        'warehouse_id',
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
    ];

    protected $cancelable = [
        'reference',
        'date',
        'product_id',
        'warehouse_id',
        'currency',
        'order_detail_id'
    ];

    protected $invertible = [
        'qty',
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
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
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
            'order_detail_id' => $this->order_detail_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function inout()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Inout');
    }

    public function orderDetail()
    {
        return $this->hasOne('Werp\Modules\Core\Products\Models\OrderDetail', 'id', 'order_detail_id');
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
}
