<?php

namespace Werp\Modules\Core\Base\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\SaveAction;
use Werp\Builders\UpdateAction;
use Werp\Builders\SaveAndNewAction;
use Werp\Builders\SaveAndEditAction;

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
            ->addAction(new SaveAndEditAction)
            ->addAction(new SaveAndNewAction)
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this
            ->editConfig($this->editTitle)
            ->makeInputs()
            ->addAction(new UpdateAction)
            ->addAction(new SaveAndNewAction)
            ->setData($data)
        ;

        return $this->view();
    }

    abstract protected function makeInputs();
}