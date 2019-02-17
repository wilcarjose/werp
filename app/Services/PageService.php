<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 16/02/19
 * Time: 04:03 PM
 */

namespace App\Services;


class PageService
{
    protected $page;
    protected $title;
    protected $route;
    protected $edit = false;
    protected $action;
    protected $short_action;
    protected $data = [];

    public function showPage($page, $action, $data = [])
    {
        if ($page == 'user' && $action == 'new') {
            return $this->createUserPage();
        }

        if ($page == 'user' && $action == 'edit') {
            return $this->editUserPage($data);
        }

        return view('admin.base.page', [
            'page' => $this->showPage($page, $action, $data)
        ]);
    }

    public function createUserPage()
    {
        $this->setPage('user')
            ->setTitle('Usuarios')
            ->setRoute('admin.user')
            ->setAction('Nuevo usuario')
            ->setShortAction('Nuevo')
            ;

        return $this->view();
    }

    public function editUserPage($data)
    {
        $this->data = $data;

        $this->setPage('user')
            ->setTitle('Usuarios')
            ->setRoute('admin.user')
            ->setAction('Editar usuario')
            ->setShortAction('Editar')
            ->setSaveBtn('Actualizar')
            ->setEdit()
            ->setInputs($data)
            ;

        return $this->view();
    }

    public function getObjectId()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    public function setPage($pageName)
    {
        $this->page = collect(config('pages.'.$pageName));

        return $this;
    }

    public function getPage()
    {
        $this->page;
    }

    public function setInputs($data)
    {
        $page = $this->page->toArray();

        collect($data)->each(function ($value, $key) use (&$page) {
            if (array_has($page, 'inputs.' . $key . '.attr.value')) {
                array_set($page, 'inputs.' . $key . '.attr.value', $value);
            }
        });

        $this->page = collect($page);

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        $this->page->put('title', $title);
        $this->setBreadcrumbName('object', $title);

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->page->put('action', $action);

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setShortAction($action)
    {
        $this->short_action = $action;
        $this->page->put('short_action', $action);
        $this->setBreadcrumbName('action', $action);
        return $this;
    }

    public function setEdit($edit = true)
    {
        $this->edit = $edit;
        $this->page->put('edit', $edit);
        $this->setBreadcrumbRoute('action', $this->getActionRoute());

        return $this;
    }

    public function edit()
    {
        return $this->edit;
    }

    public function setSaveBtn($value)
    {
        $page = $this->page->toArray();
        array_set($page, 'actions.save.attr.text', $value);
        $this->page = collect($page);

        return $this;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        $this->page->put('route', $route);

        $this->setBreadcrumbRoute('object', $this->getListRoute());
        $this->setBreadcrumbRoute('action', $this->getActionRoute());

        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getUpdateRoute()
    {
        return route($this->route.'.edit', $this->getObjectId());
    }

    public function getCreateRoute()
    {
        return route($this->route.'.create');
    }

    public function getListRoute()
    {
        return route($this->route.'.index');
    }

    public function getActionRoute()
    {
        return $this->edit ? $this->getUpdateRoute() : $this->getCreateRoute();
    }

    public function view()
    {
        return view('admin.base.page', [
            'page' => $this
        ]);
    }

    public function getBreadcrums()
    {
        return $this->page->get('breadcrumb', []);
    }

    public function setBreadcrumbName($item, $value)
    {
        $page = $this->page->toArray();
        array_set($page, 'breadcrumb.'.$item.'.text', $value);
        $this->page = collect($page);

        return $this;
    }

    public function setBreadcrumbRoute($item, $value)
    {
        $page = $this->page->toArray();
        array_set($page, 'breadcrumb.'.$item.'.route', $value);
        $this->page = collect($page);

        return $this;
    }

    public function getInputs()
    {
        return $this->page->get('inputs', []);
    }

    public function getActions()
    {
        return $this->page->get('actions', []);
    }
}