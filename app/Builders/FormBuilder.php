<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:33 PM
 */

namespace App\Builders;


class FormBuilder extends ModuleBuilder
{
    protected $edit = false;
    protected $action;
    protected $short_action;
    protected $data = [];
    protected $inputs;
    protected $actions;

    public function getObjectId()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setShortAction($action)
    {
        $this->short_action = $action;
        return $this;
    }

    public function setEdit($edit = true)
    {
        $this->edit = $edit;
        return $this;
    }

    public function edit()
    {
        return $this->edit;
    }

    public function getEditRoute()
    {
        return route($this->route.'.edit', $this->getObjectId());
    }

    public function getCreateRoute()
    {
        return route($this->route.'.create');
    }

    public function getActionRoute()
    {
        return $this->edit ? $this->getEditRoute() : $this->getCreateRoute();
    }

    public function getUpdateRoute()
    {
        return route($this->route.'.update', $this->getObjectId());
    }

    public function getStoreRoute()
    {
        return route($this->route.'.store');
    }

    public function getSaveRoute()
    {
        return $this->edit ? $this->getUpdateRoute() : $this->getStoreRoute();
    }

    public function view()
    {
        return view('admin.base.form', [
            'page' => $this
        ]);
    }

    public function addInput(InputBuilder $input)
    {
        $this->inputs = $this->to_collection($this->inputs);
        $this->inputs->push($input);
        return $this;
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    public function setInputs($inputs)
    {
        $this->inputs = $this->to_collection($inputs);

        return $this;
    }

    public function addAction(ActionBuilder $action)
    {
        $this->actions = $this->to_collection($this->actions);
        $this->actions->push($action);
        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function setActions($actions)
    {
        $this->actions = $this->to_collection($actions);

        return $this;
    }
}