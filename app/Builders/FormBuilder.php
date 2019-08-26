<?php

namespace Werp\Builders;

use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class FormBuilder // extends ModuleBuilder
{
    use BaseBuilder;

    protected $id;
    protected $objectId = null;
    protected $edit = false;
    protected $action;
    protected $data = [];
    protected $inputs;
    protected $actions = [];
    protected $maxWidth = false;
    protected $midWidth = true;
    protected $middleWidth = false;
    protected $state = null;
    protected $stateColor = null;
    protected $advanced = false;
    protected $list = null;
    protected $filters = [];
    protected $filter = null;
    protected $goBack = null;
    protected $printAction = null;
    protected $route = null;
    protected $mainRoute = null;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function makeInputs()
    {
        return $this;
    }

    public function setObjectId($id = null)
    {
        $this->objectId = isset($this->data['id']) ? $this->data['id'] : $id;
        return $this;
    }

    public function getObjectId()
    {
        return $this->objectId;
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

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setMainRoute($mainRoute, $params = [])
    {
        $this->mainRoute = route($this->route.'.'.$mainRoute, $params);
        return $this;
    }

    public function getMainRoute()
    {
        return $this->mainRoute;
    }

    public function setPrintAction($printAction)
    {
        $this->printAction = $printAction;
        return $this;
    }

    public function getPrintAction()
    {
        return $this->printAction;
    }

    public function hasPrintAction()
    {
        return $this->getPrintAction();
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
        return $this->getGoBack() ?
            route($this->route.'.update', ['id' => $this->getObjectId(), 'go_back' => $this->getGoBack()]) :
            route($this->route.'.update', $this->getObjectId());
    }

    public function getStoreRoute()
    {
        return $this->getGoBack() ?
            route($this->route.'.store', ['go_back' => $this->getGoBack()]) :
            route($this->route.'.store');
    }

    public function getSaveRoute()
    {
        if ($this->mainRoute) {
            return $this->getMainRoute();
        }

        return $this->edit ? $this->getUpdateRoute() : $this->getStoreRoute();
    }

    public function addInput(InputBuilder $input)
    {
        $this->inputs = $this->to_collection($this->inputs);
        $this->inputs->push($input);
        return $this;
    }

    public function addSelect(SelectBuilder $input)
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

    public function setList($list)
    {
        $this->list = $list;
        return $this;
    }

    public function getList()
    {
        return $this->list;
    }

    public function hasList()
    {
        return !is_null($this->list);
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function hasFilter()
    {
        return !is_null($this->filter);
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function hasFilters()
    {
        return !is_null($this->filters);
    }

    public function addFilters($filter)
    {
        $this->filters = $this->to_collection($this->filters);
        $this->filters->push($filter);
        return $this;
    }

    public function setAdvancedOptions($advanced = true)
    {
        $this->advanced = $advanced;
        return $this;
    }

    public function advancedOption()
    {
        return $this->advanced;
    }

    public function maxWidth()
    {
        return $this->maxWidth;
    }

    public function midWidth()
    {
        return $this->midWidth;
    }

    public function middleWidth()
    {
        return $this->middleWidth;
    }

    public function setMaxWidth()
    {
        $this->maxWidth = true;
        $this->midWidth = false;
        $this->middleWidth = false;
        return $this;    
    }

    public function setMidWidth()
    {
        $this->midWidth = true;
        $this->maxWidth = false;
        $this->middleWidth = false;
        return $this;
    }

    public function setMiddleWidth()
    {
        $this->maxWidth = false;
        $this->midWidth = false;
        $this->middleWidth = true;
        return $this;    
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setStateColor($stateColor)
    {
        $this->stateColor = $stateColor;
        return $this;
    }

    public function getStateColor()
    {
        return $this->stateColor;
    }

    public function setData($data)
    {
        foreach ($this->getInputs() as $input) {
            if (isset($data[$input->getName()])) {
                $input->setValue($data[$input->getName()]);
            }

            if (isset($data['state']) && $data['state'] != Basedoc::PE_STATE) {
                $input->disabled();
            }
        }

        return $this->setObjectId($data['id']);
    }

    public function getGoBack()
    {
        return $this->goBack;
    }

    public function setGoBack($goBack)
    {
        $this->goBack = $goBack;
        return $this;
    }

    public function goBackNew()
    {
        $this->goBack = 'new';
        return $this;
    }

    public function goBackEdit()
    {
        $this->goBack = 'edit';
        return $this;
    }

    public function goBackList()
    {
        $this->goBack = 'list';
        return $this;
    }

    public function goBackHome()
    {
        $this->goBack = 'home';
        return $this;
    }
}