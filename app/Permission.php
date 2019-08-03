<?php

namespace Werp;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
