<?php

namespace Werp;

use Ramsey\Uuid\Uuid;
use Werp\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Werp\Notifications\AdminResetPassword;
use Werp\Modules\Core\Base\Models\BaseAuthenticatable;

class Admin extends BaseAuthenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'pic', 'active', 'designation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }
}
