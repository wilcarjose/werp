<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class PriceList extends Model
{
    protected $table = 'price_lists';

    const EXCHANGE = 'exchange';
    const MANUALLY = 'manually';
    const FORMULA = 'formula';
    const IMPORT = 'import';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'starting_at', 'description', 'price_list_type_id', 'doctype_id', 'type',
        'reference_price_list_type_id', 'amount_operation_id', 'reference', 'round', 'exchange_rate_id',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'starting_at' => $this->starting_at,
            //'state' => $this->stateArray(),
            'state' => $this->state,
            'price_list_type_id' => $this->price_list_type_id,
            'reference_price_list_type_id' => $this->reference_price_list_type_id,
            'doctype_id' => $this->doctype_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'amount_operation_id' => $this->amount_operation_id,
            'exchange_rate_id' => $this->exchange_rate_id,
            'reference' => $this->reference,
            'round' => $this->round,
            'type' => $this->type,
        ];
    }

    /**
     * Get the lines for the inventory.
     */
    public function lines()
    {
        return $this->hasMany('Werp\Modules\Core\Maintenance\Models\Price', 'price_list_id', 'id');
    }

    public function getTotals()
    {
        return [];
    }

    public function priceListType()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\PriceListType', 'price_list_type_id');
    }

    public function referencePriceListType()
    {
        return $this->belongsTo('Werp\Modules\Core\Maintenance\Models\PriceListType', 'reference_price_list_type_id');
    }

    public function operation()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\AmountOperation', 'id', 'amount_operation_id');
    }

    public function exchangeRate()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\ExchangeRate', 'id', 'exchange_rate_id');
    }

    public function getState($state = null)
    {
        if ($state) {
            return config('products.document.actions.pri.'.$state);
        }

        return config('products.document.actions.pri.'.$this->state);
    }

    protected function stateArray()
    {
        $data = config('products.document.actions.pri.'.$this->state);

        return [
            'name' => trans($data['after_name']),
            'color' => $data['color'],
            'key' => $data['key'],
            'state' => $this->state
        ];
    }
}
