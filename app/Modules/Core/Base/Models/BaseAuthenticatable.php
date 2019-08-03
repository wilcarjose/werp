<?php

namespace Werp\Modules\Core\Base\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BaseAuthenticatable extends Authenticatable
{
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
}
