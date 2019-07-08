<?php

namespace Werp\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';
}
