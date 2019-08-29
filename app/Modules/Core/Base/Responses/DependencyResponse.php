<?php

namespace Werp\Modules\Core\Base\Responses;

class DependencyResponse
{
    protected $success = [];
    protected $data = [];

    public function __construct($dependencies)
    {
    	$this->success = !empty($dependencies);
    	$this->data = $dependencies;
    }

    public function success()
    {
        return $this->success;
    }

    public function data()
    {
        return $this->data;
    }

    public function __toString()
    {
    	$message = trans('view.texts.associated_to_item') . ' ( ';

    	foreach ($this->data as $data) {
    		$message .= trans($data['name']) . ', ';
    	}

    	return substr($message, 0). ')';
    }
}