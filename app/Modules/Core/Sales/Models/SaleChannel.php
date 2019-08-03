<?php

namespace Werp\Modules\Core\Sales\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class SaleChannel extends Model
{
    protected $table = 'sales_channels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'amount_operation_id',
    ];

    public function operation()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\AmountOperation', 'id', 'amount_operation_id');
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'amount_operation_id' => $this->amount_operation_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}