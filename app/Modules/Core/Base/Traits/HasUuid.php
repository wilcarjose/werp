<?php

namespace Werp\Modules\Core\Base\Traits;
 
use Ramsey\Uuid\Uuid;
 
trait HasUuid
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