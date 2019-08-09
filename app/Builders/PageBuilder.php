<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:33 PM
 */

namespace Werp\Builders;


class PageBuilder extends ModuleBuilder
{
    protected $forms;
    protected $short_action;

    public function init($title)
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle($title)
            ->setRoute($this->moduleRoute)
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function setShortAction($action)
    {
        $this->short_action = $action;
        return $this;
    }

    public function addForm(FormBuilder $form)
    {
        $this->forms = $this->to_collection($this->forms);
        $this->forms->push($form);
        return $this;
    }

    public function setForms($forms)
    {
        $this->forms = $this->to_collection($forms);
        return $this;
    }

    public function getForms()
    {
        return $this->forms;
    }

    public function newConfig()
    {
        return $this
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action));
    }

    public function editConfig()
    {
        return $this
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ;
    }

    public function view()
    {
        return view('admin.base.form', [
            'page' => $this
        ]);
    }


}