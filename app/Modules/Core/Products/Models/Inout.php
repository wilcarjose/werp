<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Inout extends Model
{
    const OUT_TYPE = 'OUT';
    const IN_TYPE = 'IN';

    protected $table = 'inouts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'order_code',
        'description',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'currency_id',
        'doctype_id',
        'warehouse_id',
        'partner_id',
        'date',
        'type',
        'state',
        'reference',
        'alternate_code'
    ];

    protected $copyable = [
        'code',
        'description',
        'doctype_id',
        'warehouse_id',
        'date',
        'type',
        'currency_id',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'partner_id',
        'alternate_code'
    ];

    protected $cancelable = [
        'description',
        'doctype_id',
        'warehouse_id',
        'date',
        'type',
        'currency_id',
        'order_code',
        'partner_id',
        'alternate_code'
    ];

    protected $invertible = [
        'total_price',
        'total_tax',
        'total_discount',
        'total',
    ];

    /**
     * Get the detail for the inventory.
     */
    public function detail()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\InoutDetail', 'inout_id', 'id');
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
     * The orders that belong to the inout.
     */
    public function orders()
    {
        return $this->belongsToMany('Werp\Modules\Core\Products\Models\Order');
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
            'updated_at' => $this->updated_at,
            'order_code' => $this->order_code,
            'total_price' => $this->total_price,
            'total_tax' => $this->total_tax,
            'total_discount' => $this->total_discount,
            'total' => $this->total,
            'currency_id' => $this->currency_id,
            'partner_id' => $this->partner_id,
            'alternate_code' => $this->alternate_code,
        ];
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

        $data['code'] = $this->code . '-R';
        $data['reference'] = $this->code;
        $data['state'] = Basedoc::CA_STATE;

        return $data;
    }

    public function getType()
    {
        return $this->type == self::OUT_TYPE ? Basedoc::IO_DOC : Basedoc::IE_DOC;
    }

    public function getState($state = null)
    {
        if ($state) {
            return config('products.document.actions.'.$this->getType().'.'.$state);
        }

        return config('products.document.actions.'.$this->getType().'.'.$this->state);
    }

    public function partner()
    {
        return $this->belongsTo('Werp\Modules\Core\Purchases\Models\Partner');
    }

    public function currency()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency');
    }
}
