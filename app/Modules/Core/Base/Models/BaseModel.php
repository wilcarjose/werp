<?php

namespace Werp\Modules\Core\Base\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
	use SoftDeletes;
	
    const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

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
