<?php

namespace Werp\Modules\Core\Base\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
	 public $collects;

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