<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

    protected $table = 'config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value', 'translate_key', 'description'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value1' => $this->value1,
            'translate_key' => $this->translate_key,
            'description' => $this->description,
        ];
    }
}
