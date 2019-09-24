<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class InventoryDetail extends Model
{
    protected $table = 'inventory_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'date',
        'description',
        'qty',
        'inventory_id',
        'product_id',
        'warehouse_id'
    ];

    protected $copyable = [
        'date',
        'description',
        'qty',
        'product_id',
        'warehouse_id'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'date' => $this->date,
            'description' => $this->description,
            'qty' => $this->qty,
            'inventory_id' => $this->inventory_id,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function inventory()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Inventory');
    }

    public function getMaster()
    {
        return $this->inventory;
    }
}
