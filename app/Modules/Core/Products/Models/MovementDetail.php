<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class MovementDetail extends Model
{
    protected $table = 'movement_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'date',
        'qty',
        'movement_id',
        'product_id',
        'warehouse_from_id',
        'warehouse_to_id'
    ];

    protected $cancelable = [
        'date',
        'product_id',
        'qty',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'date' => $this->date,
            'qty' => $this->qty,
            'movement_id' => $this->movement_id,
            'product_id' => $this->product_id,
            'warehouse_from_id' => $this->warehouse_from_id,
            'warehouse_to_id' => $this->warehouse_to_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function movement()
    {
        return $this->belongsTo('Werp\Modules\Core\Products\Models\Movement');
    }

     public function cancelableData()
    {
        $data = [];

        foreach ($this->cancelable as $cancel) {
            $data[$cancel] = $this->toArray()[$cancel];
        }

        $data['reference'] = $this->reference . '-R';
        $data['warehouse_from_id'] = $this->warehouse_to_id;
        $data['warehouse_to_id'] = $this->warehouse_from_id;

        return $data;
    }

    public function getMaster()
    {
        return $this->movement;
    }
}
