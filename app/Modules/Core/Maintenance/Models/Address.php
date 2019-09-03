<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;
use Werp\Modules\Core\Base\Traits\RestrictSoftDeletes;

class Address extends Model
{
    use RestrictSoftDeletes;

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

    /**
     * The relations restricting model deletion
     */
    protected $restrictDeletes = ['branchOffices', 'companies', 'partner', 'partners', 'warehouses'];

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

    public function branchOffices()
    {
        return $this->hasMany('Werp\Modules\Core\Maintenance\Models\BranchOffice', 'address_id');
    }

    public function companies()
    {
        return $this->belongsToMany('Werp\Modules\Core\Maintenance\Models\Company');
    }

    public function partner()
    {
        return $this->hasMany('Werp\Modules\Core\Purchases\Models\Partner', 'address_id');   
    }

    public function partners()
    {
        return $this->belongsToMany('Werp\Modules\Core\Purchases\Models\Partner');
    }

    public function warehouses()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\Warehouse');
    }
}
