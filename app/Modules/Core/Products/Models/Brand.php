<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

    protected $table = 'brands';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'country', 'logo',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'country' => $this->country,
            'logo' => $this->logo,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }

}
