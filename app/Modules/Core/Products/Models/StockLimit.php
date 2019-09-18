<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class StockLimit extends Model
{
    protected $table = 'stock_limit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'max_qty',
        'min_qty',
        'product_id',
        'warehouse_id',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'max_qty' => $this->max_qty,
            'min_qty' => $this->min_qty,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
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
