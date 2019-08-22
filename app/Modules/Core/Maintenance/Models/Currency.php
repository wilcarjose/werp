<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $appends = ['name_and_abbr'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'abbr', 'symbol', 'numeric_code'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_and_abbr' => $this->name . ' - '.$this->abbr,
            'description' => $this->description,
            'abbr' => $this->abbr,
            'symbol' => $this->symbol,
            'numeric_code' => $this->numeric_code,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function getNameAndAbbrAttribute()
    {
        return $this->name . ' - '.$this->abbr;
    }


}
