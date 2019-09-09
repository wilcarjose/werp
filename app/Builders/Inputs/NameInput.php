<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Inputs;


class NameInput extends TextInput
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
    public function __construct($value = null, $disabled = false, $icon = null)
    {
        $this->name = 'name';
        $this->type = 'input';
        $this->icon = $icon;
        $this->text = trans('view.name');
        $this->value = $value;
        $this->disabled = $disabled;
    }
}