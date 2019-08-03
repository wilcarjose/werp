<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Company extends Model
{
    protected $table = 'companies';

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

    /**
     * Get the detail for the inventory.
     */
    public function branchOffices()
    {
        return $this->hasMany('Werp\Modules\Core\Maintenance\Models\BranchOffice', 'company_id', 'id');
    }
}
