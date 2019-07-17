<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'type',
        'date',
        'description',
        'qty',
        'sign',
        'product_id',
        'warehouse_id'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'type' => $this->type,
            'date' => $this->date,
            'description' => $this->description,
            'qty' => $this->qty,
            'sign' => $this->sign,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
        ];
    }

    public function warehouse()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Warehouse');
    }

    public function product()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Product');
    }
}
