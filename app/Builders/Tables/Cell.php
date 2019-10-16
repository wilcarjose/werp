<?php

namespace Werp\Builders\Tables;

class Cell
{
	protected $label = null;
    protected $type = 'label';
    protected $data = null;

    public function __construct($label = null)
    {
        $this->label = $label;
    }

    public function isCheck()
    {
        return isset($this->type) && $this->type == 'check';
    }

    public function isInput()
    {
        return isset($this->type) && $this->type == 'input';
    }

    public function setInputData($id, $name, $value)
    {
        $data = [
            'id' => $id,
            'name' => 'prices',
            'value' => $value
        ];

        $this->data = (object)$data;

        $this->type = 'input';

        return $this;
    }

    public function data()
    {
        return $this->data;
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
