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
        'warehouse_id'
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
            'created_at' => $this->created_at,
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
        ];
    }

    public function inout()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Inout');
    }
}
