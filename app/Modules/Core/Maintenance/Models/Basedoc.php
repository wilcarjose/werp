<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Illuminate\Database\Eloquent\Model;

class Basedoc extends Model
{
	const STATE_ACTIVE   = 'active';
    const STATE_INACTIVE = 'inactive';

    const IN_DOC = 'IN';
    const PL_DOC = 'PL';
    const PO_DOC = 'PO';
    const SO_DOC = 'SO';
    const IE_DOC = 'IE';
    const IO_DOC = 'IO';
    const IM_DOC = 'IM';

    const PE_STATE = 'PE';
    const PR_STATE = 'PR';
    const CA_STATE = 'CA';
    const RE_STATE = 'RE';

    protected $table = 'basedocs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }

    /**
     * Get the detail for the inventory.
     */
    public function doctypes()
    {
        return $this->hasMany('Werp\Modules\Core\Maintenance\Models\Doctype', 'basedoc_id', 'id');
    }
}
