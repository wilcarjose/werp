<?php

namespace Werp\Modules\Core\Sales\Models;

use Werp\Modules\Core\Products\Models\Order;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class TaxDiscount extends Model
{
    protected $table = 'taxs_discounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'amount_operation_id', 'type', 'is_tax',
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

    public function scopeDiscounts($query)
    {
        return $query->where('is_tax', 'n');
    }

    public function scopeTaxs($query)
    {
        return $query->where('is_tax', 'y');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'amount_operation_id' => $this->amount_operation_id,
            'is_tax' => $this->is_tax,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}