<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $type = Basedoc::IN_DOC;

    //protected $stateArray = ['jj'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'doctype_id',
        'warehouse_id',
        'date',
        'state',
        'reference'
    ];

    protected $copyable = [
        'description',
        'doctype_id',
        'warehouse_id',
        'date',
    ];

    /**
     * Get the lines for the inventory.
     */
    public function lines()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\InventoryLine', 'inventory_id', 'id');
    }

    public function getTotals()
    {
        return [];
    }

    public function getlines()
    {
        return $this->lines()->get();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'doctype_id' => $this->doctype_id,
            'warehouse_id' => $this->warehouse_id,
            'date' => $this->date,
            'state' => $this->state,
            'reference' => $this->reference,
            'created_at' => $this->created_at
        ];
    }

    public function getType()
    {
        return $this->type;
    }

    public function getState($state = null)
    {
        if ($state) {
            return config('products.document.actions.'.Basedoc::IN_DOC.'.'.$state);
        }

        return config('products.document.actions.'.Basedoc::IN_DOC.'.'.$this->state);
    }
}
