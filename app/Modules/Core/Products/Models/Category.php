<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }

    public function isProduct()
    {
        return $this->type == 'product';
    }

    public function isNotProduct()
    {
        return !$this->isProduct();
    }

    public function isType($type)
    {
        return $this->type == $type;
    }
}
