<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Money\Money;
use Money\Currency;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Price extends Model
{
    protected $table = 'prices';

    protected $priceObject = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'starting_at',
        'currency_id',
        'currency_abbr',
        'price',
        'product_id',
        'price_list_id',
        'price_list_type_id',
        'amount_operation_id',
        'base_price',
        'before_price',
        'operation_name',
        'operation_calc',
        'operation_value',
        'exchange_rate_id',
        'active',
    ];

    public function priceListType()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\PriceListType', 'id', 'price_list_type_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'starting_at' => $this->starting_at,
            'price' => $this->price,
            'base_price' => $this->base_price,
            'before_price' => $this->before_price,
            'currency_id' => $this->currency_id,
            'currency_abbr' => $this->currency_abbr,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_id' => $this->product_id,
            'price_list_id' => $this->price_list_id,
            'operation_name' => $this->operation_name,
            'operation_calc' => $this->operation_calc,
            'operation_value' => $this->operation_value,
            'price_list_type_id' => $this->price_list_type_id,
            'amount_operation_id' => $this->amount_operation_id,
            'exchange_rate_id' => $this->exchange_rate_id,
        ];
    }

    public function setPrice(Money $price)
    {
        $this->priceObject = $price;
        return $this; 
    }

    public function getPrice()
    {
        return is_null($this->priceObject) ?
            new Money(intval($this->price * 100),  new Currency($this->priceListType->currency)) :
            $this->priceObject;
    }

    public function priceList()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\PriceList');
    }

    public function getMaster()
    {
        return $this->priceList;
    }

    public function product()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Product');
    }

    public function currency()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\Currency');
    }
}
