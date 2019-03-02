<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:33 PM
 */

namespace App\Builders;


class ListBuilder extends ModuleBuilder
{
    protected $config;

    protected $showStatus;

    protected $fields;

    public function view()
    {
        return view('admin.base.list', [
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


    public function makeConfig()
    {
        // "{ title: 'Usuarios', fields: [{ field: 'fullname', name: 'nombre'}, {field: 'email', name: 'email'}], route: '/admin/user', show_status: true }";
        $fields = [];
        foreach ($this->getFields() as $field => $name) {
            $fields[] = ['field' => $field, 'name' => $name];
        }

        $config = [
            'title'  => $this->getTitle(),
            'route'  => $this->getListRoute(),
            'show_status' => $this->getShowStatus(),
            'fields' => $fields
        ];

        $this->setConfig(json_encode($config));
    }
}