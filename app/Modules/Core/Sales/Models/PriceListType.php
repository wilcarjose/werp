<?php

namespace Werp\Modules\Core\Sales\Models;

use Werp\Modules\Core\Sales\Models\Price;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class PriceListType extends Model
{
    protected $table = 'price_list_types';

    const PURCHASE_TYPE = 'purchases';
    const SALE_TYPE = 'sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'currency_abbr', 'description', 'type', 'currency_id'
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
            ->active()
            ->get()
            ->unique('product_id');
    }

    public function scopeSales($query)
    {
        return $query->where('type', self::SALE_TYPE);
    }

    public function scopePurchases($query)
    {
        return $query->where('type', self::PURCHASE_TYPE);
    }

    public function scopeSaleLists($query)
    {
        return $query->active()->where('type', self::SALE_TYPE);
    }

    public function scopePurchaseLists($query)
    {
        return $query->active()->where('type', self::PURCHASE_TYPE);
    }

    public function currency()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'currency_abbr' => $this->currency_abbr,
            'currency_id' => $this->currency_id,
            'active' => $this->active,
            'type' => $this->type
        ];
    }
}