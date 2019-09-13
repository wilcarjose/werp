<?php

namespace Werp\Builders;


class InputGroupBuilder
{
    use BaseBuilder;

    protected $inputs;
    protected $width;
    protected $icon;
    protected $active = false;

    /**
     * TabBuilder constructor.
     * @param $id
     * @param $text
     */
    public function __construct($icon = null, $active = false, $width = '')
    {
        $this->width = $width;
        $this->active = $active;
        $this->icon = $icon;
        $this->inputs = collect([]);
    }

    /**
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return TabBuilder
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     * @return mixed
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     * @return TabBuilder
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function addInput($input)
    {
        $this->inputs = $this->to_collection($this->inputs);
        $this->inputs->push($input);
        return $this;
    }

    public function setInputs($inputs)
    {
        $this->inputs = $this->to_collection($inputs);
        return $this;
    }

    public function inputs()
    {
        return $this->inputs;
    }

    public function hasInputs()
    {
        return $this->inputs && $this->inputs->isNotEmpty();
    }

    /**
     * @return mixed
     */
    public function icon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return TabBuilder
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

     /**
     * @return mixed
     */
    public function active()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return TabBuilder
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }
}