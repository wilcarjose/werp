<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Models\BaseModel;

class Product extends BaseModel
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
            'status' => $this->status,
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

    public function currentPrice($priceListType)
    {
        return $this->prices()->where('price_list_type_id', $priceListType)
            ->where('status', 'active')
            ->where('starting_at', '<', date('Y-m-d H:i:s'))
            ->orderBy('starting_at', 'desc')
            ->firstOrFail();
    }

    public function prices()
    {
        return $this->hasMany('Werp\Modules\Core\Sales\Models\Price', 'product_id', 'id');
    }
}
