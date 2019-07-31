<?php

namespace Werp\Modules\Core\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class Movement extends Model
{
    protected $table = 'movements';

    protected $type = Basedoc::IM_DOC;

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
        'warehouse_from_id',
        'warehouse_to_id',
        'date',
        'state',
        'reference'
    ];

    protected $cancelable = [
        'description',
        'doctype_id',
        'date',
    ];

    /**
     * Get the detail for the inventory.
     */
    public function detail()
    {
        return $this->hasMany('Werp\Modules\Core\Products\Models\MovementDetail', 'movement_id', 'id');
    }

    public function getTotals()
    {
        return [];
    }

    public function getDetail()
    {
        return $this->detail()->get(); 
    }

    public function hasDetail()
    {
        return $this->detail()->count() > 0;
    }    

    public function hasNotDetail()
    {
        return !$this->hasDetail();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'doctype_id' => $this->doctype_id,
            'warehouse_from_id' => $this->warehouse_from_id,
            'warehouse_to_id' => $this->warehouse_to_id,
            'date' => $this->date,
            'state' => $this->state,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function getType()
    {
        return $this->type;
    }

    public function getState($state = null)
    {
        if ($state) {
            return config('products.document.actions.'.Basedoc::IM_DOC.'.'.$state);
        }

        return config('products.document.actions.'.Basedoc::IM_DOC.'.'.$this->state);
    }

    public function cancelableData()
    {
        $data = [];

        foreach ($this->cancelable as $cancel) {
            $data[$cancel] = $this->toArray()[$cancel];
        }

        $data['code'] = $this->code . '-R';
        $data['reference'] = $this->code;
        $data['warehouse_from_id'] = $this->warehouse_to_id;
        $data['warehouse_to_id'] = $this->warehouse_from_id;
        $data['state'] = Basedoc::CA_STATE;

        return $data;
    }
}
