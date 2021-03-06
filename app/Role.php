<?php

namespace Werp;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function detachPermissionFrom(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }
}
