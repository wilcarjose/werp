<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:33 PM
 */

namespace Werp\Builders;


class ModuleBuilder extends PageBuilder
{
    protected $title;
    protected $breadcrumbs;
    protected $route;

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setBreadcrumbs($breadcrumbs)
    {
        $this->breadcrumbs = $this->to_collection($breadcrumbs);
        return $this;
    }

    public function addBreadcrumb(BreadcrumbBuilder $breadcrumb)
    {
        $this->breadcrumbs = $this->to_collection($this->breadcrumbs);
        $this->breadcrumbs->push($breadcrumb);
        return $this;
    }

    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getListRoute()
    {
        return route($this->route.'.index');
    }
}