<?php

namespace Werp\Modules\Core\Sales\Resources;

use Werp\Modules\Core\Base\Resources\BaseResource;

class AddressResource extends BaseResource
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
            'name' => $this->when($this->show('name'), $this->name),
            'address_1' => $this->when($this->show('address_1'), $this->address_1),
            'address_2' => $this->when($this->show('address_2'), $this->address_2),
            'address_3' => $this->when($this->show('address_3'), $this->address_3),
            'country' => $this->when($this->show('country'), $this->country),
            'state' => $this->when($this->show('state'), $this->state),
            'city' => $this->when($this->show('city'), $this->city),
            'urbanization' => $this->when($this->show('urbanization'), $this->urbanization),
            'zip_code' => $this->when($this->show('zip_code'), $this->zip_code),
            'latitude' => $this->when($this->show('latitude'), $this->latitude),
            'longitude' => $this->when($this->show('longitude'), $this->longitude),
            'active' => $this->when($this->show('active'), $this->active),
            'created_at' => $this->when($this->show('created_at'), $this->created_at),
            'updated_at' => $this->when($this->show('updated_at'), $this->updated_at),
        ];
    }    
}
