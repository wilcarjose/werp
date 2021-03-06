<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Inputs;


class TextInput extends InputBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $label = null, $value = null, $disable = false, $icon = null)
    {
        $this->name = $name;
        $this->type = 'input';
        $this->icon = $icon;
        $this->text = $label;
        $this->value = $value;
        $this->disable = $disable;
    }
}