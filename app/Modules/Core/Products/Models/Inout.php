<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

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
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'doctype_id',
        'warehouse_id',
        'partner_id',
        'date',
        'type',
        'state',
        'reference'
    ];

    /**
     * Get the detail for the inventory.
     */
    public function detail()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\InoutDetail', 'inout_id', 'id');
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
            'order_code' => $this->order_code,
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
            'partner_id' => $this->partner_id,
        ];
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
}
