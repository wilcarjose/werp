<?php

namespace Werp\Builders\Inputs;

class HiddenInput extends InputBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $value = null)
    {
        $this->name = $name;
        $this->type = 'hidden';
        $this->value = $value;
    }
}