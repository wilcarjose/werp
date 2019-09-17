<?php

namespace Werp\Builders\Checks;

use Werp\Builders\BaseBuilder;

class RadioBuilder
{
    use BaseBuilder;

    protected $name;
    protected $type;
    protected $advancedOption = false;
    protected $width;
    protected $options = [];

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $value
     */
    public function __construct($name = null)
    {
        $this->name = $name;
        $this->type = 'radio';
        $this->width = 's12 m6';
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

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function width()
    {
        return $this->width;
    }

    public function addOption(RadioOptionBuilder $option)
    {
        $this->options = $this->to_collection($this->options);
        $this->options->push($option);
        return $this;
    }

    public function setOptions($options)
    {
        $this->options = $this->to_collection($options);
        return $this;
    }

    public function options()
    {
        return $this->options;
    }

    public function hasOptions()
    {
        return $this->options && $this->options->isNotEmpty();
    }
}