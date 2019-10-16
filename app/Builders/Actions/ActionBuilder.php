<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 18/02/19
 * Time: 06:37 PM
 */

namespace Werp\Builders\Actions;


class ActionBuilder
{
    const TYPE_BUTTON = 'button';
    const TYPE_LINK   = 'link';
    const EVENT_SUBMIT = 'submit';

    protected $name;
    protected $type;
    protected $event;
    protected $text;
    protected $icon;
    protected $route;
    protected $value = null;
    protected $class = 'btn waves-effect waves-set';
    protected $iconPosition = 'left';
    protected $confirm = true;

    /**
     * ActionBuilder constructor.
     * @param $name
     * @param $type
     * @param $event
     * @param $text
     * @param $icon
     * @param $route
     */
    public function __construct($name = null, $type = null, $text = null, $icon = null, $event = null, $route = null, $value = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->event = $event;
        $this->text = $text;
        $this->icon = $icon;
        $this->route = $route;
        $this->value = $value;
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
     * @return ActionBuilder
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
     * @return ActionBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     * @return ActionBuilder
     */
    public function setEvent($event)
    {
        $this->event = $event;
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
     * @return ActionBuilder
     */
    public function setText($text)
    {
        $this->text = $text;
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
     * @return ActionBuilder
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
     * @param mixed $icon
     * @return ActionBuilder
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     * @return ActionBuilder
     */
    public function setRoute($route)
    {
        $this->route = $route;
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
     * @return ActionBuilder
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     * @return ActionBuilder
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return mixed
     */
    public function confirm()
    {
        return $this->confirm;
    }

    /**
     * @param mixed $confirm
     * @return ActionBuilder
     */
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;
        return $this;
    }
}
