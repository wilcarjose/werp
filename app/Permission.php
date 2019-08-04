<?php

namespace Werp;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	public $incrementing = false;
 
    protected $keyType = 'string';
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

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
