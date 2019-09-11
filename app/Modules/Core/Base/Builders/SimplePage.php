<?php

namespace Werp\Modules\Core\Base\Builders;

use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\Actions\SaveAction;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Actions\SaveAndNewAction;
use Werp\Builders\Actions\SaveAndEditAction;

abstract class SimplePage extends PageBuilder
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
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->newTitle)
            ->setInputs($this->getInputs())
            ->addAction(new SaveAndEditAction)
            ->addAction(new SaveAndNewAction)
        ;

        return $this
            ->setMessagesWidth('s8 push-m2')
            ->setShortAction('Nueva')
            ->newConfig()
            ->addForm($form)
            ->view()
        ;
    }

    public function editPage($data)
    {
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->editTitle)
            ->setInputs($this->getInputs())
            ->addAction(new UpdateAction)
            ->addAction(new SaveAndNewAction)
            ->setData($data)
            ->setEdit();
        ;

        return $this
            ->setMessagesWidth('s8 push-m2')
            ->setShortAction('Editar')
            ->editConfig()
            ->addForm($form)
            ->view()
        ;
    }
}