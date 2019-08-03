<?php

namespace Werp\Modules\Core\Products\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Category extends Model
{
    const PRODUCT_TYPE = 'product';
    const SUPPLIER_TYPE = 'supplier';
    const CUSTOMER_TYPE = 'customer';

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'category_id', 
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'category_id' => $this->category_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function isProduct()
    {
        return $this->type == self::PRODUCT_TYPE;
    }

    public function isNotProduct()
    {
        return !$this->isProduct();
    }

    public function isType($type)
    {
        return $this->type == $type;
    }

    public function category()
    {
        return $this->hasOne('Werp\Modules\Core\Products\Models\Category', 'id', 'category_id');
    }
}
