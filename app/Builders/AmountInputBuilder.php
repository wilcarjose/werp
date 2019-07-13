<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders;


class AmountInputBuilder extends TextInputBuilder
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
        $this->name = $name;
        $this->type = 'number';
        $this->icon = $icon;
        $this->text = $text; //trans('view.email');
        $this->value = $value;
        $this->disable = $disable;
    }
}