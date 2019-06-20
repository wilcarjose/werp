<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders;


class SelectBuilder
{
    protected $name;
    protected $type;
    protected $icon;
    protected $text;
    protected $value;
    protected $data;
    protected $disable;
    protected $none;
    protected $advancedOption;

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $icon = null, $data = [], $value = null, $none = false, $disable = false, $advancedOption = false)
    {
        $this->name  = $name;
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text;
        $this->value = $value;
        $this->data  = $data;
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return InputBuilder
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return InputBuilder
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return InputBuilder
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return InputBuilder
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return InputBuilder
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isDisable()
    {
        return $this->disable;
    }

    /**
     * @param mixed $disable
     * @return InputBuilder
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function hasNone()
    {
        return $this->none;
    }

    /**
     * @param mixed $none
     * @return InputBuilder
     */
    public function setNone($none)
    {
        $this->none = $none;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isAdvancedOption()
    {
        return $this->advancedOption;
    }

    /**
     * @param mixed $advancedOption
     * @return InputBuilder
     */
    public function setAdvancedOption($advancedOption)
    {
        $this->advancedOption = $advancedOption;
        return $this;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isValue($value)
    {
        return !is_null($this->value) && $this->value == $value;
    }
}