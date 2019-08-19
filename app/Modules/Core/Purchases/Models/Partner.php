<?php

namespace Werp\Modules\Core\Purchases\Models;

use Werp\Modules\Core\Base\Models\BaseModel as Model;

class Partner extends Model
{
    const SUPPLIER_TYPE = 'supplier';
    const CUSTOMER_TYPE = 'customer';

    protected $table = 'partners';

    protected $appends = ['doc_and_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document',
        'name',
        'last_name',
        'phone',
        'mobile',
        'email',
        'web',
        'photo',
        'type',
        'is_supplier',
        'is_customer',
        'description',
        'birthdate',
        'contact_person',
        'economic_activity',
        'gender',
        'category_id',
        'address_id',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'doc_and_name' => $this->document . ' - '.$this->name,
            'document' => $this->document,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'web' => $this->web,
            'photo' => $this->photo,
            'type' => $this->type,
            'is_supplier' => $this->is_supplier,
            'is_customer' => $this->is_customer,
            'description' => $this->description,
            'birthdate' => $this->birthdate,
            'contact_person' => $this->contact_person,
            'economic_activity' => $this->economic_activity,
            'gender' => $this->gender,
            'category_id' => $this->category_id,
            'address_id' => $this->address_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'address' => $this->address ? $this->address->toArray() : [],
        ];
    }

    public function getDocAndNameAttribute()
    {
        return $this->document . ' - '.$this->name;
    }

    public function address()
    {
        return $this->hasOne('Werp\Modules\Core\Maintenance\Models\Address', 'id', 'address_id');
    }

    public function isSupplier()
    {
        return $this->is_supplier == 'y';
    }

    public function isNotSupplier()
    {
        return !$this->isSupplier();
    }

    public function isCustomer()
    {
        return $this->is_customer == 'y';
    }

    public function isNotCustomer()
    {
        return !$this->isCustomer();
    }
}
