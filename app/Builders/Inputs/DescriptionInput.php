<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Inputs;


class DescriptionInput extends TextAreaInput
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($value = null, $disabled = false, $icon = null)
    {
        $this->name = 'description';
        $this->type = 'textarea';
        $this->icon = $icon;
        $this->text = trans('view.description');
        $this->value = $value;
        $this->disabled = $disabled;
        $this->width = 'l12';
    }

}