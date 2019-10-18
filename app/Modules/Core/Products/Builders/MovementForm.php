<?php

namespace Werp\Modules\Core\Products\Builders;

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

class MovementForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.movements';
    protected $mainTitle = 'Movimientos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new DateInput,
            new WarehouseSelect('warehouse_from_id', trans('view.from')),
            new WarehouseSelect('warehouse_to_id', trans('view.to')),
            (new DescriptionInput)->advancedOption(),
            (new DoctypeSelect(Basedoc::IM_DOC, Config::INV_DEFAULT_IM_DOC))->advancedOption(),
        ];
    }

    public function createPage()
    {
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->newTitle)
            ->setInputs($this->getInputs())
            ->addAction(new ContinueAction)
            ->setAdvancedOptions()
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
        $disable = $data['state'] != Basedoc::PE_STATE;
        $noProcessed = $data['state'] == Basedoc::PE_STATE;

        $inputs = [
            //new CodeInput,
            (new DateInput)->setDisable($disable),
            (new WarehouseSelect('warehouse_from_id', trans('view.from')))->setDisable($disable),
            (new WarehouseSelect('warehouse_to_id', trans('view.to')))->setDisable($disable),
            (new DescriptionInput)->advancedOption()->setDisable($disable),
            (new DoctypeSelect(Basedoc::IM_DOC, Config::INV_DEFAULT_IM_DOC))->advancedOption()->setDisable($disable),
        ];

        if ($data['reference']) {
            $inputs[] = (new TextInput('reference', 'Referencia'))->advancedOption()->disabled();
        }

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction('Movimiento # ' . $data['code'])
            ->setInputs($inputs)
            ->setData($data)
            ->setAdvancedOptions()
            ->setEdit();
        ;

        if ($noProcessed) {
            $form->addAction(new UpdateAction);
        }

        $form
            ->setState(trans(config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.color'));
            ;

        $actionKeys = config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IM_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route($this->moduleRoute.'.'.$action['key'], $data['id'])));
        }

        return $this
            ->addList(new MovementLinesList(false, $data['id'], $disable))
            ->setListsWidth('s8 push-m2')
            ->setMessagesWidth('s8 push-m2')
            ->setShortAction($this->editTitle)
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}
