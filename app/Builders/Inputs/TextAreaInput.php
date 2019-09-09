<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Inputs;


class TextAreaInput extends InputBuilder
{
    protected $name;
    protected $type;
    protected $icon;
    protected $text;
    protected $value;
    protected $disabled = false;

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $label = null, $value = null, $disabled = false, $icon = null)
    {
        $this->name = $name;
        $this->type = 'textarea';
        $this->icon = $icon;
        $this->text = $label;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->width = 'l12';
    }
}