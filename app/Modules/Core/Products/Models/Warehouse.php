<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'created_at' => $this->created_at
        ];
    }
}
