<?php

namespace Werp\Builders;


class CardBuilder
{
    protected $id;
    protected $view;
    protected $data;

    /**
     * TabBuilder constructor.
     * @param $id
     * @param $text
     */
    public function __construct($view = null, $data = [], $id = null)
    {
        $this->id = $id;
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return string
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function view()
    {
        return $this->view;
    }

    /**
     * @param mixed $view
     * @return View
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    public function render()
    {
        return $this->view ? $this->view->render() : '';
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return array
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}