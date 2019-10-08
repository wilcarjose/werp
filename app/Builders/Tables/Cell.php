<?php

namespace Werp\Builders\Tables;

class Cell
{
	protected $label = null;
    protected $check;

    public function __construct($label = null, $check = null)
    {
        $this->check = $check;
        $this->label = $label;
    }

    public function check()
    {
        return $this->check;
    }

    public function setCheck($check)
    {
        $this->check = $check;
        return $this;
    }

    public function isCheck()
    {
        return !is_null($this->check);
    }    

    public function label()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function isLabel()
    {
        return !is_null($this->label);
    }
}