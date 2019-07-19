<?php

namespace Werp\Modules\Core\Maintenance\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    const INV_DEFAULT_IN_DOC = 'inv_default_inventory_doctype';
    const INV_DEFAULT_WAREHOUSE = 'inv_default_warehouse';
    const PRI_DEFAULT_PL_DOC = 'pri_default_price_list_doctype';

    protected $table = 'config';

    public function toArray()
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'module' => $this->module,
            'created_at' => $this->created_at,
            'translate_key' => $this->translate_key,
            'description' => $this->description,
        ];
    }
}
