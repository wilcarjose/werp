<?php

namespace Werp\Builders\Inputs;

class ColorInput extends TextInput
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $value = null, $disable = false, $icon = null)
    {
        $this->name = $name ?: 'color';
        $this->type = 'color';
        $this->icon = $icon;
        $this->text = $text ?: trans('view.color');
        $this->value = $value;
        $this->disable = $disable;
    }
}