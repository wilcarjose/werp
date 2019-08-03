<?php

namespace Werp\Modules\Core\Sales\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class PriceListType extends Model
{
    protected $table = 'price_list_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'currency', 'description', 'type'
    ];

    /**
     * Get the detail for the inventory.
     */
    public function prices()
    {
        return $this->hasMany('Werp\Modules\Core\Sales\Models\Price', 'price_list_type_id', 'id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'currency' => $this->currency,
            'status' => $this->status,
            'type' => $this->type
        ];
    }
}
