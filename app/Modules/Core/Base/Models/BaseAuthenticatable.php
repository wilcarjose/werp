<?php

namespace Werp\Modules\Core\Base\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BaseAuthenticatable extends Authenticatable
{
	use SoftDeletes;

	const STATUS_ACTIVE   = 'on';
    const STATUS_INACTIVE = 'off';
	
    public $incrementing = false;
 
    protected $keyType = 'string';

    /**
	 *  Setup model event hooks
	 */
	public static function boot()
	{
	    parent::boot();

	    self::creating(function ($model) {
	        $model->id = (string) Uuid::uuid4();
	    });
	}

	public function scopeActive($query)
    {
        return $query->where('active', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', self::STATUS_INACTIVE);
    }
}
