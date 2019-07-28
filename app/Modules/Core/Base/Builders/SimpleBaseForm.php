<?php

namespace Werp\Modules\Core\Base\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\SaveActionBuilder;
use Werp\Builders\UpdateActionBuilder;

abstract class SimpleBaseForm extends FormBuilder
{
    protected $moduleRoute = '';
    protected $mainTitle = '';
    protected $newTitle = '';
    protected $editTitle = '';

    public function __construct()
    {
        $this->init($this->mainTitle);
    }

    public function createPage()
    {
        $this
            ->newConfig($this->newTitle)
            ->makeInputs()
            ->addAction(new SaveActionBuilder)
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this
            ->editConfig($this->editTitle)
            ->makeInputs()
            ->addAction(new UpdateActionBuilder)
            ->setData($data)
        ;

        return $this->view();
    }

    abstract protected function makeInputs();
}