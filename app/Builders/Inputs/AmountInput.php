<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Inputs;


class AmountInput extends TextInput
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
        $this->name = $name ?: 'amount';
        $this->type = 'number';
        $this->icon = $icon;
        $this->text = $text ?: trans('view.amount');
        $this->value = $value ?: 0.00;
        $this->disable = $disable;
    }
}