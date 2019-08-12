<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:33 PM
 */

namespace Werp\Builders;


class ListBuilder extends ModuleBuilder
{
    protected $config;

    protected $showStatus;

    protected $showSearch = true;

    protected $showAdd = true;

    protected $fields;

    protected $filter = null;

    protected $emptyList = false;

    protected $useModal = false;

    protected $deleteMultiple = true;

    protected $showMessages = true;

    protected $showAdvancedOptions = true;

    protected $disable = false;

    protected $paginate = true;

    protected $showState = false;

    protected $modalConfig = null;

    protected $showActions = true;

    protected $showMultiActions = true;

    protected $reloadOnSave = false;

    protected $name = false;

    protected $moreOptions = 'Opciones avanzadas';



    public function view()
    {
        $name = $this->name ?: 'list';

        return view('admin.base.'.$name, [
            'page' => $this
        ]);
    }

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }


    /**
     * @return mixed
     */
    public function getShowStatus()
    {
        return $this->showStatus;
    }

    /**
     * @param mixed $showStatus
     * @return ListBuilder
     */
    public function setShowStatus($showStatus)
    {
        $this->showStatus = $showStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowSearch()
    {
        return $this->showSearch;
    }

    /**
     * @param mixed $showSearch
     * @return ListBuilder
     */
    public function setShowSearch($showSearch)
    {
        $this->showSearch = $showSearch;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getShowAdd()
    {
        return $this->showAdd;
    }

    /**
     * @param mixed $showAdd
     * @return ListBuilder
     */
    public function setShowAdd($showAdd)
    {
        $this->showAdd = $showAdd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     * @return ListBuilder
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param mixed $filter
     * @return ListBuilder
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmptyList()
    {
        return $this->emptyList;
    }

    /**
     * @param mixed $emptyList
     * @return ListBuilder
     */
    public function setEmptyList($emptyList)
    {
        $this->emptyList = $emptyList;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUseModal()
    {
        return $this->useModal;
    }

    /**
     * @param mixed $useModal
     * @return ListBuilder
     */
    public function setUseModal($useModal)
    {
        $this->useModal = $useModal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeleteMultiple()
    {
        return $this->deleteMultiple;
    }

    /**
     * @param mixed $deleteMultiple
     * @return ListBuilder
     */
    public function setDeleteMultiple($deleteMultiple)
    {
        $this->deleteMultiple = $deleteMultiple;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowMessages()
    {
        return $this->showMessages;
    }

    /**
     * @param mixed $showMessages
     * @return ListBuilder
     */
    public function setShowMessages($showMessages)
    {
        $this->showMessages = $showMessages;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowAdvancedOptions()
    {
        return $this->showAdvancedOptions;
    }

    /**
     * @param mixed $showAdvancedOptions
     * @return ListBuilder
     */
    public function setShowAdvancedOptions($showAdvancedOptions)
    {
        $this->showAdvancedOptions = $showAdvancedOptions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * @param mixed $disable
     * @return ListBuilder
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaginate()
    {
        return $this->paginate;
    }

    /**
     * @param mixed $paginate
     * @return ListBuilder
     */
    public function setPaginate($paginate)
    {
        $this->paginate = $paginate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowState()
    {
        return $this->showState;
    }

    /**
     * @param mixed $showState
     * @return ListBuilder
     */
    public function setShowState($showState)
    {
        $this->showState = $showState;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowActions()
    {
        return $this->showActions;
    }

    /**
     * @param mixed $showActions
     * @return ListBuilder
     */
    public function setShowActions($showActions)
    {
        $this->showActions = $showActions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowMultiActions()
    {
        return $this->showMultiActions;
    }

    /**
     * @param mixed $showMultiActions
     * @return ListBuilder
     */
    public function setShowMultiActions($showMultiActions)
    {
        $this->showMultiActions = $showMultiActions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReloadOnSave()
    {
        return $this->reloadOnSave;
    }

    /**
     * @param mixed $reloadOnSave
     * @return ListBuilder
     */
    public function setReloadOnSave($reloadOnSave)
    {
        $this->reloadOnSave = $reloadOnSave;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getModalConfig()
    {
        return $this->modalConfig;
    }

    /**
     * @param mixed $modalConfig
     * @return ListBuilder
     */
    public function setModalConfig($modalConfig)
    {
        $this->modalConfig = $modalConfig;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getMoreOptions()
    {
        return $this->moreOptions;
    }

    /**
     * @param mixed $moreOptions
     * @return ListBuilder
     */
    public function setMoreOptions($moreOptions)
    {
        $this->moreOptions = $moreOptions;
        return $this;
    }

    public function makeConfig()
    {
        // "{ title: 'Usuarios', fields: [{ field: 'fullname', name: 'nombre'}, {field: 'email', name: 'email'}], route: '/admin/user', show_status: true }";
        //$fields = [];
        //foreach ($this->getFields() as $field => $name) {
        //    $fields[] = ['field' => $field, 'name' => $name];
        //}

        $config = [
            'title'  => $this->getTitle(),
            'route'  => $this->getListRoute(),
            'show_status' => $this->getShowStatus(),
            'show_search' => $this->getShowSearch(),
            'use_modal' => $this->getUseModal(),
            'filter'    => $this->getFilter(),
            'empty_list'    => $this->getEmptyList(),
            'delete_multiple'    => $this->getDeleteMultiple(),
            'show_messages' => $this->getShowMessages(),
            'show_state' => $this->getShowState(),
            'paginate'    => $this->getPaginate(),
            'disable'    => $this->getDisable(),
            'modal'      => $this->getModalConfig(),
            'fields' => $this->getFields(),
            'show_actions' => $this->getShowActions(),
            'show_multi_actions' => $this->getShowMultiActions(),
            'reload_on_save' => $this->getReloadOnSave(),
            'show_advanced' => $this->getShowAdvancedOptions(),
            'show_add' => $this->getShowAdd(),
            'more_options' => $this->getMoreOptions(),
        ];

        $this->setConfig(json_encode($config));
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return 'list';
    }
}