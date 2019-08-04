<?php

namespace Werp\Modules\Core\Sales\Models;

use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Tax extends Model
{
    protected $table = 'taxs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'amount_operation_id', 'type',
    ];

    public function operation()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\AmountOperation', 'id', 'amount_operation_id');
    }

    public function scopeSales($query)
    {
        return $query->where('type', Order::SALE_TYPE);
    }

    public function scopePurchases($query)
    {
        return $query->where('type', Order::PURCHASE_TYPE);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'amount_operation_id' => $this->amount_operation_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}