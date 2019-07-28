<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    const CURRENT_DOLAR_CONVERSION = 'current_dolar_convertion';
    const INV_DEFAULT_WAREHOUSE = 'inv_default_warehouse';
    const INV_DEFAULT_IN_DOC = 'inv_default_in_doc';
    const PRI_DEFAULT_PL_DOC = 'pri_default_pl_doc';
    const INV_DEFAULT_IE_DOC = 'inv_default_ie_doc';
    const INV_DEFAULT_PO_DOC = 'inv_default_po_doc';
    const INV_DEFAULT_IO_DOC = 'inv_default_io_doc';
    const INV_DEFAULT_SO_DOC = 'inv_default_so_doc';
    const INV_DEFAULT_IM_DOC = 'inv_default_im_doc';

    protected $table = 'config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value', 'type', 'translate_key', 'description'
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'type' => $this->type,
            'module' => $this->module,
            'created_at' => $this->created_at,
            'translate_key' => $this->translate_key,
            'description' => $this->description,
        ];
    }
}
