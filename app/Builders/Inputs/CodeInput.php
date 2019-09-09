<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Inputs;


class CodeInput extends TextInput
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
    public function __construct($name = null, $text = null, $value = null, $disabled = true, $icon = null)
    {
        $this->name = $name ?: 'code';
        $this->type = 'code';
        $this->icon = $icon;
        $this->text = $text ?: trans('view.code');
        $this->value = $value;
        $this->disabled = $disabled;
    }
}