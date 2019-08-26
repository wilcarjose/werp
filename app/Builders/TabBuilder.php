<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 02:05 PM
 */

namespace Werp\Builders;


class TabBuilder
{
    protected $name;
    protected $id;
    protected $active = false;
    protected $disable = false;
    protected $icon = null;
    protected $iconPosition = 'left';
    protected $color = '#2a56c6';

    /**
     * TabBuilder constructor.
     * @param $id
     * @param $text
     */
    public function __construct($id = null, $name = null, $active = false, $icon = null, $disable = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->active = $active;
        $this->disable = $disable;
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TabBuilder
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return TabBuilder
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $iconPosition
     * @return TabBuilder
     */
    public function setIconPosition($iconPosition)
    {
        $this->iconPosition = $iconPosition;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIconPosition()
    {
        return $this->iconPosition;
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

    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $disable
     * @return TabBuilder
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
        return $this;
    }

    public function isDisable()
    {
        return $this->disable;
    }

    /**
     * @param mixed $color
     * @return TabBuilder
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }
}