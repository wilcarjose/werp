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
        'name', 'description', 'document', 
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'document' => $this->document,
            'document2' => $this->document2,
            'logo' => $this->logo,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'phone3' => $this->phone3,
            'address_id' => $this->address_id,
            'active' => $this->active,
            'created_at' => $this->created_at
        ];
    }

    /**
     * Get the branch offices.
     */
    public function branchOffices()
    {
        return $this->hasMany('Werp\Modules\Core\Maintenance\Models\BranchOffice', 'company_id', 'id');
    }
}
