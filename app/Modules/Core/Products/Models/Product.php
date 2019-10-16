<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;
use Werp\Modules\Core\Base\Traits\RestrictSoftDeletes;

class Product extends Model
{
    use RestrictSoftDeletes;

	protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'part_number',
        'barcode',
        'qrcode',
        'link',
        'image',
        'is_service',
        'brand_id',
        'partner_id',
        'description',
        'category_id',
        'uom_id',
        'ml_enabled',  // ML
        'ml_item_id',  // ML
    ];

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['prices', 'transactions', 'stock', 'inventories', 'categories',
        'uoms', 'brands', 'partners', 'stockLimits', 'orders', 'inouts', 'movements'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'part_number' => $this->part_number,
            'barcode' => $this->barcode,
            'qrcode' => $this->qrcode,
            'link' => $this->link,
            'image' => $this->image,
            'is_service' => $this->is_service,
            'brand_id' => $this->brand_id,
            'partner_id' => $this->partner_id,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'uom_id' => $this->uom_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'ml_enabled' => $this->ml_enabled,  // ML
            'ml_item_id' => $this->ml_item_id,  // ML
        ];
    }

    public function isService()
    {
        return $this->is_service == 'y';
    }

    public function category()
    {
        return $this->hasOne('Werp\Modules\Core\Products\Models\Category', 'id', 'category_id');
    }

    public function uom()
    {
        return $this->hasOne('Werp\Modules\Core\Products\Models\Uom', 'id', 'uom_id');
    }

    public function brand()
    {
        return $this->hasOne('Werp\Modules\Core\Products\Models\Brand', 'id', 'brand_id');
    }

    public function currentPrice($priceListTypeId, $default = 0)
    {
        $price = $this->currentPriceObject($priceListTypeId);

        return $price ? $price->price : $default;
    }

    public function currentPriceObject($priceListTypeId)
    {
        return $this->prices()->where('price_list_type_id', $priceListTypeId)
            ->active()
            ->where('starting_at', '<', date('Y-m-d H:i:s'))
            ->orderBy('starting_at', 'desc')
            ->first();
    }

    public function prices()
    {
        return $this->hasMany('Werp\Modules\Core\Sales\Models\Price');
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

    public function categories()
    {
        return $this->belongsToMany('Werp\Modules\Core\Products\Models\Category', 'product_category');
    }

    public function uoms()
    {
        return $this->belongsToMany('Werp\Modules\Core\Products\Models\Uom');
    }

    public function brands()
    {
        return $this->belongsToMany('Werp\Modules\Core\Products\Models\Brand', 'product_brand');
    }

    public function partners()
    {
        return $this->belongsToMany('Werp\Modules\Core\Purchases\Models\Partner', 'product_partner');
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

    public function movements()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\MovementDetail');
    }
}
