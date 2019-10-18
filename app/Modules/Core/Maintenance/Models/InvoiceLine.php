<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class InvoiceLine extends Model
{
    protected $table = 'invoice_lines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'reference',
        'price',
        'tax',
        'discount',
        'full_price',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'currency_id',
        'qty',
        'invoice_id',
        'product_id',
        'tax_id',
        'discount_id',
        'price_id',
        'company_id',
        'order_line_id',
    ];

    protected $copyable = [

    ];

    protected $cancelable = [

    ];

    protected $invertible = [
        'qty',
        'price',
        'tax',
        'discount',
        'full_price',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'reference' => $this->reference,
            'price' => $this->price,
            'tax' => $this->tax,
            'discount' => $this->discount,
            'full_price' => $this->full_price,
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
            'currency_id' => $this->currency_id,
            'qty' => $this->qty,
            'invoice_id' => $this->invoice_id,
            'product_id' => $this->product_id,
            'tax_id' => $this->tax_id,
            'discount_id' => $this->discount_id,
            'price_id' => $this->price_id,
            'company_id' => $this->company_id,
            'order_line_id' => $this->order_line_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function invoice()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Invoice');
    }

    public function orderLine()
    {
        return $this->hasOne('Werp\Modules\Core\Products\Models\OrderLine', 'id', 'order_line_id');
    }

    public function cancelableData()
    {
        $data = [];

        foreach ($this->cancelable as $cancel) {
            $data[$cancel] = $this->toArray()[$cancel];
        }

        foreach ($this->invertible as $invert) {
            $data[$invert] = (-1) * $this->toArray()[$invert];
        }

        //$data['reference'] = $this->reference . '-R';

        return $data;
    }

    public function getMaster()
    {
        return $this->invoice;
    }

    public function product()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Product');
    }

    public function currency()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency');
    }
}
