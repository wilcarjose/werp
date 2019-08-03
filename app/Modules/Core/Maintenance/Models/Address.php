<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Address extends Model
{
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address_1',
        'address_2',
        'address_3',
        'country',
        'state',
        'city',
        'urbanization',
        'zip_code',
        'latitude',
        'longitude',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_3' => $this->address_3,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'urbanization' => $this->urbanization,
            'zip_code' => $this->zip_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
