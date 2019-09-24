<?php

namespace Werp\Modules\Core\Base\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Werp\Modules\Core\Maintenance\Models\Company;

class BaseModel extends Model
{
	use SoftDeletes;

    const STATUS_ACTIVE   = 'on';
    const STATUS_INACTIVE = 'off';

    public $incrementing = false;
 
    protected $keyType = 'string';

    protected $checkOnDrop = [];

    protected $copyable = [];

    public function getCheckOnDrop()
    {
        return $this->checkOnDrop;
    }

    public function getCopyable()
    {
        return $this->copyable;
    }

    /**
	 *  Setup model event hooks
	 */
	public static function boot()
	{
	    parent::boot();

	    self::creating(function ($model) {
	        $model->id = (string) Uuid::uuid4();
            $model->company_id = session('company') ? session('company')->id : Company::first()->id;
	    });

        static::addGlobalScope(new CompanyScope);
	}

	public function scopeActive($query)
    {
        return $query->where('active', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', self::STATUS_INACTIVE);
    }

    public function getCompanyKey()
    {
        return $this->getTable().'.company_id';
    }
}
