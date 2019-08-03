<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Doctype extends Model
{
    protected $table = 'doctypes';

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
            'basedoc_id' => $this->basedoc_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'prefix' => $this->prefix,
            'increment_number' => $this->increment_number,
            'last_number' => $this->last_number,
            'use_zeros' => $this->use_zeros,
            'number_long' => $this->number_long,
        ];
    }
}
