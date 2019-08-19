<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Order extends Model
{
    const PURCHASE_TYPE = 'PURC';
    const SALE_TYPE = 'SALE';

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'currency_id',
        'doctype_id',
        'warehouse_id',
        'partner_id',
        'price_list_type_id',
        'sale_channel_id',
        'tax_id',
        'discount_id',
        'date',
        'type',
        'state',
        'reference',
        'is_invoice_pending',
        'is_delivery_pending',
        'alternate_code',
        'payment_method_id'
    ];

    /**
     * Get the detail for the inventory.
     */
    public function detail()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\OrderDetail', 'order_id', 'id');
    }

    public function getTotals()
    {
        return [
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
        ];
    }

    /**
     * The inouts that belong to the order.
     */
    public function inouts()
    {
        return $this->belongsToMany('Werp\Modules\Core\Products\Models\Inout');
    }

    public function getDetail()
    {
        return $this->detail()->get(); 
    }

    public function hasDetail()
    {
        return $this->detail()->count() > 0;
    }    

    public function hasNotDetail()
    {
        return !$this->hasDetail();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'doctype_id' => $this->doctype_id,
            'warehouse_id' => $this->warehouse_id,
            'date' => $this->date,
            'type' => $this->type,
            'state' => $this->state,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
            'currency_id' => $this->currency_id,
            'partner_id' => $this->partner_id,
            'is_invoice_pending' => $this->is_invoice_pending,
            'is_delivery_pending' => $this->is_delivery_pending,
            'alternate_code' => $this->alternate_code,
            'price_list_type_id' => $this->price_list_type_id,
            'discount_id' => $this->discount_id,
            'tax_id' => $this->tax_id,
            'sale_channel_id' => $this->sale_channel_id,
            'payment_method_id' => $this->payment_method_id,
        ];
    }

    public function getType()
    {
        return $this->type == self::PURCHASE_TYPE ? Basedoc::PO_DOC : Basedoc::SO_DOC;
    }

    public function getState($state = null)
    {
        if ($state) {
            return config('sales.document.actions.'.$this->getType().'.'.$state);
        }

        return config('sales.document.actions.'.$this->getType().'.'.$this->state);
    }

    public function priceListType()
    {
        return $this->belongsTo('Werp\Modules\Core\Sales\Models\PriceListType', 'price_list_type_id');
    }

    public function currency()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency');
    }

    public function scopeSales($query)
    {
        return $query->where('type', self::SALE_TYPE);
    }

    public function scopePurchases($query)
    {
        return $query->where('type', self::PURCHASE_TYPE);
    }
}
