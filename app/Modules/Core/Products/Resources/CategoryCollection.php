<?php

namespace Werp\Modules\Core\Products\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    public $collects = 'Werp\Modules\Core\Products\Resources\CategoryResource';
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "success" => true,
            "code" => 0,
            "locale" => "es",
            "message" => "OK",
            "data" => $this->collection,
        ];
    }
}
