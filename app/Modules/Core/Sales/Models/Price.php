<?php

namespace Werp\Modules\Core\Sales\Models;

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
        'starting_at', 'currency', 'price', 'product_id', 'price_list_id', 'price_list_type_id', 'active'
    ];

    public function priceListType()
    {
        return $this->hasOne('Werp\Modules\Core\Sales\Models\PriceListType', 'id', 'price_list_type_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'starting_at' => $this->starting_at,
            'price' => $this->price,
            'currency' => $this->currency,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_id' => $this->product_id,
            'price_list_id' => $this->price_list_id,
            'price_list_type_id' => $this->price_list_type_id
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
        return $this->belongsTo('Werp\Modules\Core\Sales\Models\PriceList');
    }

    public function getMaster()
    {
        return $this->priceList;
    }
}
