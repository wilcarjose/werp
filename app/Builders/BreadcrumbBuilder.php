<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 02:05 PM
 */

namespace App\Builders;


class BreadcrumbBuilder
{
    protected $name;
    protected $route;
    protected $text;

    /**
     * BreadcrumbBuilder constructor.
     * @param $route
     * @param $text
     */
    public function __construct($route = null, $text = null)
    {
        $this->route = $route;
        $this->text = $text;
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
     * @return BreadcrumbBuilder
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return BreadcrumbBuilder
     */
    public function setRoute($route)
    {
        $this->route = $route;
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
     * @return BreadcrumbBuilder
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }


}