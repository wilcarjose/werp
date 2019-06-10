<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'doctype_id',
        'warehouse_id',
        'date',

    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'doctype_id' => $this->doctype_id,
            'warehouse_id' => $this->warehouse_id,
            'date' => $this->date,
            'created_at' => $this->created_at
        ];
    }
}
