<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Illuminate\Database\Eloquent\Model;

class AmountOperation extends Model
{
	const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

    protected $table = 'amount_operations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'operation', 'value', 'round', 'config_key'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'operation' => $this->operation,
            'value' => $this->value,
            'round' => $this->round,
            'config_key' => $this->config_key,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}