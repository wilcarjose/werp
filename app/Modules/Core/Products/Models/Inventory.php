<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $type = Basedoc::IN_DOC;

    protected $stateArray = ['jj'];

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

    /**
     * Get the detail for the inventory.
     */
    public function detail()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\InventoryDetail', 'inventory_id', 'id');
    }

    public function getTotals()
    {
        return [];
    }

    public function getDetail()
    {
        return $this->detail()->get(); 
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
