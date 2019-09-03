<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class StockLimit extends Model
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
        'warehouse_id',
        'process_id',
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
            'process_id' => $this->process_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
