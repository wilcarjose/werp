<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders;


class DateBuilder extends InputBuilder
{
    protected $name;
    protected $type;
    protected $icon;
    protected $text;
    protected $value;
    protected $disable = false;
    protected $advancedOption = false;

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
        $this->name = $name ?: 'date';
        $this->type = 'date';
        $this->icon = $icon ?: 'calendar';
        $this->text = trans('view.date');
        $this->value = $value ?: date('Y-m-d H:i:s');
        $this->disable = $disable;
    }
}