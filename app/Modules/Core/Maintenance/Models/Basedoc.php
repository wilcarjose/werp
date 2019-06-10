<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Illuminate\Database\Eloquent\Model;

class Basedoc extends Model
{
	const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

    protected $table = 'basedocs';

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
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
