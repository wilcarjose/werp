<?php

namespace Werp\Modules\Core\Payments\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class BankAccount extends Model
{
    protected $table = 'branch_offices';

    const CHECK_TYPE = 'check';
    const SAVINGS_TYPE = 'savings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'number', 'account_holder', 'holder_id', 'bank_id'];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'number' => $this->number,
            'account_holder' => $this->account_holder,
            'holder_id' => $this->holder_id,
            'company_id' => $this->company_id,
            'bank_id' => $this->bank_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function bank()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\Bank');
    }
}
