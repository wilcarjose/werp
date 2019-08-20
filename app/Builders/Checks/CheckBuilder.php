<?php

namespace Werp\Builders\Checks;

class CheckBuilder
{
    protected $name;
    protected $type;
    protected $icon;
    protected $text;
    protected $value;
    protected $disable = false;
    protected $checked = false;
    protected $advancedOption = false;

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $checked = false, $disable = false, $value = null, $icon = null)
    {
        $this->name = $name;
        $this->type = 'check';
        $this->icon = $icon;
        $this->text = $text;
        $this->value = $value;
        $this->disable = $disable;
        $this->checked = $checked;
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

    /**
     * @param mixed $checked
     * @return InputBuilder
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;
        return $this;
    }

    public function getChecked()
    {
        return $this->checked;
    }

    public function checked()
    {
        $this->setChecked(true);
        return $this;
    }

    public function isChecked()
    {
        return $this->checked;
    }
}