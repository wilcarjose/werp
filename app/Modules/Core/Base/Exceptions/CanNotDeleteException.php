<?php

namespace Werp\Modules\Core\Base\Exceptions;

class CanNotDeleteException extends \Exception
{
    protected $dependencies = [];

    public function setDependencies($dependencies)
    {
    	$this->dependencies = $dependencies;

    	$this->message = 'Can not delete, those class depends of this ( ' . $this->getDependenciesAsString() . ')';
    	return $this;
    }

    public function getDependencies()
    {
    	return $this->dependencies;
    }

    public function getDependenciesAsString()
    {
    	$dependencies = '';

    	foreach ($this->getDependencies() as $dependency) {
    		$dependencies .= $dependency . ' ';
    	}

    	return $dependencies;
    }
}