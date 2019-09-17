<?php

namespace Werp\Builders\Checks;

class RadioOptionBuilder
{
    protected $id;
    protected $disable = false;
    protected $checked = false;
    protected $width;
    protected $label;
    protected $icon;

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $value
     */
    public function __construct($label = '', $id = '', $checked = false, $disable = false)
    {
        $this->label = $label;
        $this->id = $id;
        $this->checked = $checked;
        $this->width = 's12';
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return InputBuilder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function label()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return InputBuilder
     */
    public function setlabel($label)
    {
        $this->label = $label;
        return $this;
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