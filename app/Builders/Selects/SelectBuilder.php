<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders\Selects;


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
    protected $labelKey = 'name';
    protected $idKey = 'id';
    protected $isArrayItem = false;
    protected $allowNew = false;
    protected $modal = null;
    protected $width = 'm6 s12';
    protected $hide = null;
    protected $showInputs = [];
    protected $hideInputs = [];

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $data = [], $value = null, $none = false, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name;
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text;
        $this->value = $value;
        $this->setData($data);
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
     * @return SelectBuilder
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
     * @return SelectBuilder
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
        $this->isArrayItem = isset($data[0]) && is_array($data[0]);

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

    public function disabled()
    {
        $this->setDisable(true);
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

    public function addNone()
    {
        return $this->setNone(true);
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
     * @param mixed $value
     * @return bool
     */
    public function isValue($value)
    {
        return !is_null($this->value) && $this->value == $value;
    }

    /**
     * @return mixed
     */
    public function getLabelKey()
    {
        return $this->labelKey;
    }

    /**
     * @param mixed $labelKey
     * @return InputBuilder
     */
    public function setLabelKey($labelKey)
    {
        $this->labelKey = $labelKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdKey()
    {
        return $this->idKey;
    }

    /**
     * @param mixed $idKey
     * @return InputBuilder
     */
    public function setIdKey($idKey)
    {
        $this->idKey = $idKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isArrayItem()
    {
        return $this->isArrayItem;
    }

    /**
     * @param mixed $isArrayItem
     * @return InputBuilder
     */
    public function setArrayItem($isArrayItem)
    {
        $this->isArrayItem = $isArrayItem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function allowNew()
    {
        return $this->allowNew;
    }

    /**
     * @param mixed $allowNew
     * @return InputBuilder
     */
    public function setAllowNew($allowNew)
    {
        $this->allowNew = $allowNew;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModal()
    {
        return $this->modal;
    }

    /**
     * @param mixed $modal
     * @return InputBuilder
     */
    public function setModal($modal)
    {
        $this->modal = $modal;
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
