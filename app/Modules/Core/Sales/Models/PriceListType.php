<?php

namespace Werp\Modules\Core\Sales\Models;

use Werp\Modules\Core\Sales\Models\Price;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class PriceListType extends Model
{
    protected $table = 'price_list_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'currency', 'description', 'type'
    ];

    /**
     * Get the detail for the inventory.
     */
    public function prices()
    {
        return $this->hasMany(Price::class, 'price_list_type_id', 'id');
    }

    public function currentPrices()
    {
        //return $this->prices->groupBy('product_id');
        return Price::where('price_list_type_id', $this->id)
            ->orderBy('starting_at', 'desc')
            ->get()
            ->unique('product_id');
    }

    public function scopeSaleLists($query)
    {
        return $query->active()->where('type', 'sales');
    }

    public function scopePurchaseLists($query)
    {
        return $query->active()->where('type', 'purchases');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'currency' => $this->currency,
            'active' => $this->active,
            'type' => $this->type
        ];
    }
}
