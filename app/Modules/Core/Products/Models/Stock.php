<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qty',
        'product_id',
        'warehouse_id'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'qty' => $this->qty,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
        ];
    }
}
