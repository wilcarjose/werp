<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class BranchOffice extends Model
{
    protected $table = 'branch_offices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'company_id' => $this->company_id,
            'address_id' => $this->address_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
        ];
    }

    public function address()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\Address', 'id', 'address_id');
    }
}