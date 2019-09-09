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
    protected $forms = [];
    protected $tabs = [];
    protected $rows = [];
    protected $shortAction;
    protected $width = 'm12';
    protected $tabsWidth = 'm12';
    protected $rowsWidth = 'm12';
    protected $messagesWidth = 'm12';
    protected $formsWidth = 'm12';

    public function init($title)
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle($title)
            ->setRoute($this->moduleRoute)
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function setShortAction($action)
    {
        $this->shortAction = $action;
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

    public function hasForms()
    {
        return $this->forms && $this->forms->isNotEmpty();
    }

    public function newConfig()
    {
        return $this
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->shortAction));
    }

    public function editConfig()
    {
        return $this
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->shortAction))
            ;
    }

    public function view()
    {
        return view('admin.base.page', [
            'page' => $this
        ]);
    }

    public function addTab(TabBuilder $tab)
    {
        $this->tabs = $this->to_collection($this->tabs);
        $this->tabs->push($tab);
        return $this;
    }

    public function setTabs($tabs)
    {
        $this->tabs = $this->to_collection($tabs);
        return $this;
    }

    public function getTabs()
    {
        return $this->tabs;
    }

    public function hasTabs()
    {
        return $this->tabs && $this->tabs->isNotEmpty();
    }

    public function addRow(RowBuilder $row)
    {
        $this->rows = $this->to_collection($this->rows);
        $this->rows->push($row);
        return $this;
    }

    public function setRows($rows)
    {
        $this->rows = $this->to_collection($rows);
        return $this;
    }

    public function rows()
    {
        return $this->rows;
    }

    public function hasRows()
    {
        return $this->rows && $this->rows->isNotEmpty();
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

    public function setTabsWidth($tabsWidth)
    {
        $this->tabsWidth = $tabsWidth;
        return $this;
    }

    public function tabsWidth()
    {
        return $this->tabsWidth;
    }

    public function setRowsWidth($rowsWidth)
    {
        $this->rowsWidth = $rowsWidth;
        return $this;
    }

    public function rowsWidth()
    {
        return $this->rowsWidth;
    }

    public function setMessagesWidth($messagesWidth)
    {
        $this->messagesWidth = $messagesWidth;
        return $this;
    }

    public function messagesWidth()
    {
        return $this->messagesWidth;
    }

    public function setFormsWidth($formsWidth)
    {
        $this->formsWidth = $formsWidth;
        return $this;
    }

    public function formsWidth()
    {
        return $this->formsWidth;
    }
}