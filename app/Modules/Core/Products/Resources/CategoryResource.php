<?php

namespace Werp\Modules\Core\Products\Resources;

use Werp\Modules\Core\Base\Resources\BaseResource;

class CategoryResource extends BaseResource
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
            'type' => $this->when($this->show('type'), $this->type),
            'category_id' => $this->when($this->show('category_id'), $this->category_id),
            'active' => $this->when($this->show('active'), $this->active),
            'created_at' => $this->when($this->show('created_at'), $this->created_at),
            'updated_at' => $this->when($this->show('updated_at'), $this->updated_at),
        ];
    }    
}
