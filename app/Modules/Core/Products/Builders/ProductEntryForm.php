<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\DateInput;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Inputs\TextInput;
use Werp\Builders\Inputs\CodeInput;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Actions\SaveAction;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Selects\SupplierSelectBuilder;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class ProductEntryForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.product_entry';
    protected $mainTitle = 'Entrada de productos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new DateInput,
            new SupplierSelectBuilder,
            new WarehouseSelect,
            (new DescriptionInput)->advancedOption(),
            (new TextInput('order_code', 'Código de orden'))->advancedOption()->disabled(),
            (new DoctypeSelect(Basedoc::IE_DOC, Config::INV_DEFAULT_IE_DOC))->advancedOption(),
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
            ->setShortAction('Nueva')
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
            new CodeInput,            
        ];

        if ($data['reference']) {
            $inputs[] = (new TextInput('reference', 'Referencia'))->disabled();
        }

        $inputs[] = (new DateInput)->setDisable($disable);
        $inputs[] = (new SupplierSelectBuilder)->setDisable($disable);
        $inputs[] = (new WarehouseSelect)->setDisable($disable);
        $inputs[] = (new CurrencySelect)->setDisable($disable);

        $inputs[] = (new DescriptionInput)->advancedOption()->setDisable($disable);
        $inputs[] = (new TextInput('order_code', 'Código de orden'))->advancedOption()->disabled();
        $inputs[] = (new DoctypeSelect(Basedoc::IE_DOC,  Config::INV_DEFAULT_IE_DOC))->advancedOption()->setDisable($disable);

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->editTitle)
            ->setInputs($inputs)
            ->setData($data)
            ->setAdvancedOptions()
            ->setEdit();
        ;

        if ($noProcessed) {
            $form->addAction(new UpdateAction);
        }

        $form
            ->setList(new ProductEntryDetailList(false, $data['id'], $disable))
            ->setMaxWidth()
            ->setState(trans(config('products.document.actions.'.Basedoc::IE_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IE_DOC.'.'.$data['state'].'.color'));
            ;

        $actionKeys = config('products.document.actions.'.Basedoc::IE_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IE_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.products.product_entry.'.$action['key'], $data['id'])));
        }        

        return $this
            ->setShortAction('Editar')
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}