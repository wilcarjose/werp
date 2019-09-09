<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;
use Werp\Modules\Core\Base\Traits\RestrictSoftDeletes;

class Warehouse extends Model
{
    use RestrictSoftDeletes;

    protected $table = 'warehouses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'abbr',
        'color'
    ];

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['transactions', 'stock', 'inventories', 'stockLimits', 'orders', 'inouts', 'movementsFrom', 'movementsTo'];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'abbr' => $this->abbr,
            'color' => $this->color,
            'active' => $this->active,
            'created_at' => $this->created_at
        ];
    }

    public function transactions()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\Transaction');
    }

    public function stock()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\Stock');
    }

    public function inventories()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\InventoryDetail');
    }

    public function stockLimits()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\StockLimit');
    }

    public function orders()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\OrderDetail');
    }

    public function inouts()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\InoutDetail');
    }

    public function movementsFrom()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\MovementDetail', 'warehouse_from_id');
    }

    public function movementsTo()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\MovementDetail', 'warehouse_to_id');
    }
}
