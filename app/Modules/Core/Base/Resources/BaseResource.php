<?php

namespace Werp\Modules\Core\Base\Resources;

use Illuminate\Container\Container;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
	protected $fields = [];

	/**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
        $request = Container::getInstance()->make('request');
        $this->loadFields($request);
    }

    protected function loadFields($request)
    {
        $fields = $request->get('fields', null);

        $this->fields = $fields ? explode(',', $fields) : [];
    }

    protected function show($field)
    {
        if (empty($this->fields)) {
            return true;
        }

        return in_array($field, $this->fields);
    }
}