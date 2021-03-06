<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE   = 'on';
    const STATUS_INACTIVE = 'off';

    public $incrementing = false;
 
    protected $keyType = 'string';

    protected $table = 'companies';

    protected $casts = [
        'general_config' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'document', 'document2', 'phone1', 'phone2', 'phone3', 'logo', 'email'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'document' => $this->document,
            'document2' => $this->document2,
            'logo' => $this->logo,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'phone3' => $this->phone3,
            'address_id' => $this->address_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'address' => $this->addresses->isNotEmpty() ? $this->addresses->first()->toArray() : [],
        ];
    }

    /**
     * Get the branch offices.
     */
    public function branchOffices()
    {
        return $this->hasMany('Werp\Modules\Core\Maintenance\Models\BranchOffice', 'company_id', 'id');
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

    public function scopeActive($query)
    {
        return $query->where('active', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', self::STATUS_INACTIVE);
    }

    public function addresses()
    {
        return $this->belongsToMany('Werp\Modules\Core\Maintenance\Models\Address');
    }

    public function isRight()
    {
        $config = json_to_array($this->general_config);

        if (!isset($config['completed']['warehouse']) || !$config['completed']['warehouse']) {
            return false;
        }

        if (!isset($config['completed']['currency']) || !$config['completed']['currency']) {
            return false;
        }

        return true;
    }

    public function setComplete($warehouse)
    {
        $config = json_to_array($this->general_config);

        $config['completed'][$warehouse] = true;

        $config = json_encode($config, JSON_FORCE_OBJECT);

        $this->general_config = $config;

        $this->save();
    }
}
