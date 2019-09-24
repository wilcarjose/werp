<?php

namespace Werp\Builders\Menus;

class Item
{
	protected $color = 'blue';
    protected $url = '#';
    protected $icon = 'attach_file';

    public function __construct($url, $icon, $color)
    {
        $this->url = $url;
        $this->icon = $icon;
        $this->color = $color;
    }

    public function url()
    {
        return $this->url;
    }

    public function icon()
    {
        return $this->icon;
    }

    public function color()
    {
        return $this->color;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }
}