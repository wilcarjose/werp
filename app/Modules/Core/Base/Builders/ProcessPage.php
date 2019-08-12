<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\DateInput;
use Werp\Builders\Inputs\CodeInput;
use Werp\Builders\Inputs\TextInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class ProcessPage extends PageBuilder
{
    protected $moduleRoute = '';
    protected $mainTitle = '';
    protected $newTitle = '';
    protected $editTitle = '';

    public function getInputs()
    {
        return [];
    }

    public function getDetailList()
    {
        return null;
    }

    public function createPage()
    {
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->newTitle)
            ->setInputs($this->getInputs())
            ->addAction(new ContinueAction)
            ->setAdvancedOptions()
            ->setMaxWidth()
            ->goBackEdit()
        ;

        return $this
            ->setShortAction($this->newTitle)
            ->newConfig()
            ->addForm($form)->view()
        ;
    }

    public function editPage($data)
    {
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->editTitle)
            ->setInputs($inputs)
            ->setData($data)
            ->setAdvancedOptions()
            ->setMaxWidth()
            ->setEdit();
        ;

        if ($data['state'] == Basedoc::PE_STATE) {
            $form->addAction(new UpdateAction);
        }

        $form
            ->setList($this->getDetailList())
            //->setMaxWidth()
            ->setState(trans(config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.color'));
            ;

        $actionKeys = config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IM_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route($this->moduleRoute.'.'.$action['key'], $data['id'])));
        }        

        return $this
            ->setShortAction($this->editTitle)
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}