<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Menus\Item;
use Werp\Builders\FormBuilder;
use Werp\Builders\Menus\FormMenu;
use Werp\Builders\Inputs\DateInput;
use Werp\Builders\Inputs\CodeInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class InventoryForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.inventories';
    protected $mainTitle = 'Inventarios';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new DateInput,
            new WarehouseSelect,
            (new DescriptionInput)->advancedOption(),
            (new DoctypeSelect(Basedoc::IN_DOC, Config::INV_DEFAULT_IN_DOC))->advancedOption(),
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
        $this->data = $data;

        $disable = $data['state'] != Basedoc::PE_STATE;
        $noProcessed = $data['state'] == Basedoc::PE_STATE;

        $inputs = [
            //new CodeInput,
            (new DateInput)->setDisable($disable),
            (new WarehouseSelect)->setDisable($disable),
            (new DescriptionInput)->advancedOption()->setDisable($disable),
            (new DoctypeSelect(Basedoc::IN_DOC, Config::INV_DEFAULT_IN_DOC))->advancedOption()->setDisable($disable),
        ];

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction('Inventario # ' . $data['code'])
            ->setInputs($inputs)
            ->setData($data)
            ->setAdvancedOptions()
            ->setEdit();
        ;

        if ($noProcessed) {
            $form->addAction(new UpdateAction);
        }

        $form
            //->setMaxWidth()
            ->setState(trans(config('products.document.actions.'.Basedoc::IN_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IN_DOC.'.'.$data['state'].'.color'));
            ;

        $menu = new FormMenu;
        $menu->addItem(new Item(route($this->moduleRoute.'.copy', $data['id']), 'file_copy', 'blue'));

        $form->setMenu($menu);

        $actionKeys = config('products.document.actions.'.Basedoc::IN_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IN_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route($this->moduleRoute.'.'.$action['key'], $data['id'])));
        }

        return $this
            ->addList(new InventoryLinesList(false, $data['id'], $disable))
            ->setListsWidth('s8 push-m2')
            ->setMessagesWidth('s8 push-m2')
            ->setShortAction('Editar')
            ->editConfig()
            ->addForm($form)
            ->view()
        ;
    }
}
