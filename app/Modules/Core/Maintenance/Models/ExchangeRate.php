<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class ExchangeRate extends Model
{
    protected $table = 'exchange_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'currency_from_id', 'currency_to_id', 'value', 'starting_at'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'currency_from_id' => $this->currency_from_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'currency_to_id' => $this->currency_to_id,
            'value' => $this->value,
            'starting_at' => $this->starting_at,
        ];
    }

    public function currencyFrom()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency', 'currency_from_id');
    }

    public function currencyTo()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\Currency', 'currency_to_id');
    }
}
