<?php

namespace Werp\Modules\Core\Sales\Resources;

use Werp\Modules\Core\Base\Resources\BaseResource;

class CustomerResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->when($this->show('id'), $this->id),
            'document' => $this->when($this->show('document'), $this->document),
            'name' => $this->when($this->show('name'), $this->name),
            'last_name' => $this->when($this->show('last_name'), $this->last_name),
            'phone' => $this->when($this->show('phone'), $this->phone),
            'mobile' => $this->when($this->show('mobile'), $this->mobile),
            'email' => $this->when($this->show('email'), $this->email),
            'web' => $this->when($this->show('web'), $this->web),
            'photo' => $this->when($this->show('photo'), $this->photo),
            'type' => $this->when($this->show('type'), $this->type),
            'is_supplier' => $this->when($this->show('is_supplier'), $this->is_supplier),
            'is_customer' => $this->when($this->show('is_customer'), $this->is_customer),
            'description' => $this->when($this->show('description'), $this->description),
            'birthdate' => $this->when($this->show('birthdate'), $this->birthdate),
            'contact_person' => $this->when($this->show('contact_person'), $this->contact_person),
            'economic_activity' => $this->when($this->show('economic_activity'), $this->economic_activity),
            'gender' => $this->when($this->show('gender'), $this->gender),
            'category_id' => $this->when($this->show('category_id'), $this->category_id),
            'address_id' => $this->when($this->show('address_id'), $this->address_id),
            'active' => $this->when($this->show('active'), $this->active),
            'created_at' => $this->when($this->show('created_at'), $this->created_at),
            'updated_at' => $this->when($this->show('updated_at'), $this->updated_at),
            'address' => $this->when($this->show('address') && !is_null($this->address_id), new AddressResource($this->address)),
        ];
    }    
}
