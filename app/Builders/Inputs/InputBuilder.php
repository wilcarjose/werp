<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Inputs;


class InputBuilder
{
    protected $name;
    protected $type;
    protected $icon;
    protected $text;
    protected $value;
    protected $disable = false;
    protected $advancedOption = false;
    protected $placeholder = '';
    protected $width = 'm6 s12';
    protected $hide = null;
    protected $hideInputs = [];
    protected $showInputs = [];

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $value = null, $type = 'input', $icon = null, $disable = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
        $this->text = $text;
        $this->value = $value;
        $this->disable = $disable;
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
     * @param mixed $type
     * @return InputBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param mixed $placeholder
     * @return InputBuilder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isDisabled()
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

    public function disabled()
    {
        $this->setDisable(true);
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

    public function advancedOption()
    {
        $this->setAdvancedOption(true);
        return $this;
    }

    public function hasIcon()
    {
        return !is_null($this->icon);
    }

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function width()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function hide()
    {
        return $this->hide;
    }

    /**
     * @param mixed $hide
     * @return InputBuilder
     */
    public function setHide($hide)
    {
        $this->hide = $hide;
        return $this;
    }

    /**
     * @return mixed
     */
    public function showInputs()
    {
        return $this->showInputs;
    }

    /**
     * @param mixed $showInput
     * @return InputBuilder
     */
    public function setShowInputs($showInputs)
    {
        $this->showInputs = is_array($showInputs) ? $showInputs : explode(',', $showInputs);
        return $this;
    }

    /**
     * @return mixed
     */
    public function hideInputs()
    {
        return $this->hideInputs;
    }

    /**
     * @param mixed $hideInput
     * @return InputBuilder
     */
    public function setHideInputs($hideInputs)
    {
        $this->hideInputs = is_array($hideInputs) ? $hideInputs : explode(',', $hideInputs);
        return $this;
    }
}
