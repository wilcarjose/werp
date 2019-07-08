<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
	const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

    protected $table = 'price_lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'price', 'currency', 'description', 'product_id', 'list_type_id'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'description' => $this->description,
            'currency' => $this->currency,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'date' => $this->date,
            'list_type_id' => $this->list_type_id,
            'product_id' => $this->product_id,
        ];
    }
}
