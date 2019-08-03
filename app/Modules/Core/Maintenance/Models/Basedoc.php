<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Basedoc extends Model
{
    const IN_DOC = 'IN'; // inventory
    const PL_DOC = 'PL'; // product list
    const PO_DOC = 'PO'; // purchase order
    const SO_DOC = 'SO'; // sales order
    const IE_DOC = 'IE'; // product entry
    const IO_DOC = 'IO'; // product output
    const IM_DOC = 'IM'; // inventory movement

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
            'active' => $this->active,
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
