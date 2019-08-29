<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Product extends Model
{
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
    ];

    protected $checkOnDrop = [
        [
            'class' => 'Werp\Modules\Core\Products\Models\MovementDetail',
            'field' => 'product_id',
            'name' => 'view.products.movement',
        ],
        [
            'class' => 'Werp\Modules\Core\Products\Models\InoutDetail',
            'field' => 'product_id',
            'name' => 'view.products.product_inout',
        ],
        [
            'class' => 'Werp\Modules\Core\Products\Models\OrderDetail',
            'field' => 'product_id',
            'name' => 'view.products.order',
        ],
        [
            'class' => 'Werp\Modules\Core\Sales\Models\Price',
            'field' => 'product_id',
            'name' => 'view.products.price_list',
        ],
        [
            'class' => 'Werp\Modules\Core\Products\Models\InventoryDetail',
            'field' => 'product_id',
            'name' => 'view.products.inventory',
        ],
        [
            'class' => 'Werp\Modules\Core\Products\Models\Stock',
            'field' => 'product_id',
            'name' => 'view.products.stock',
        ],
        [
            'class' => 'Werp\Modules\Core\Products\Models\Transaction',
            'field' => 'product_id',
            'name' => 'view.products.transaction',
        ],
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
            'created_at' => $this->created_at
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
        return $this->hasMany('Werp\Modules\Core\Sales\Models\Price', 'product_id', 'id');
    }
}
