<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders;


class EmailInputBuilder extends TextInputBuilder
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
        $this->name = 'email';
        $this->type = 'input';
        $this->icon = $icon;
        $this->text = trans('view.email');
        $this->value = $value;
        $this->disabled = $disabled;
    }
}