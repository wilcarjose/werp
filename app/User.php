<?php

namespace Werp;

use Ramsey\Uuid\Uuid;
use Werp\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Werp\Modules\Core\Base\Models\BaseAuthenticatable;

class User extends BaseAuthenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'active', 'profile_pic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'pic'   => $this->profile_pic
        ];
    }
}
