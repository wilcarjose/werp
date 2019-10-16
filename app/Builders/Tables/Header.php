<?php

namespace Werp\Builders\Tables;

class Header
{
	protected $label;
    protected $field;

    public function __construct($label = '', $field = '')
    {
        $this->field = $field;
        $this->label = $label;
    }

    public function field()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;
        return $this;
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
}
