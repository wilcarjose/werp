<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\Selects\TaxSelect;
use Werp\Builders\Selects\FormSelect;
use Werp\Builders\Inputs\DateInput;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Selects\DiscountSelect;
use Werp\Builders\Inputs\TextInput;
use Werp\Builders\Inputs\CodeInput;
use Werp\Builders\Actions\SaveAction;
use Werp\Builders\Selects\SaleChannelSelect;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\PaymentMethodSelect;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Selects\CustomerSelectBuilder;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Selects\SalePriceListSelect;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class SaleOrderForm extends SimplePage
{
    protected $moduleRoute = 'admin.sales.orders';
    protected $mainTitle = 'Orden de venta';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs($new = false)
    {
        if (!$new) {
            $inputs[] = new CodeInput;
        }

        $inputs[] = new DateInput;
        $inputs[] = new CustomerSelectBuilder;
        $inputs[] = new SalePriceListSelect;
        $inputs[] = new WarehouseSelect;
        $inputs[] = new SaleChannelSelect;
        $inputs[] = new TaxSelect;
        $inputs[] = new DiscountSelect;
        $inputs[] = (new PaymentMethodSelect)->setNone(true);
        $inputs[] = (new DescriptionInput)->advancedOption();
        $inputs[] = (new DoctypeSelect(Basedoc::SO_DOC, Config::INV_DEFAULT_SO_DOC))->advancedOption();

        return $inputs;
    }

    public function createPage()
    {
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->newTitle)
            ->setInputs($this->getInputs(true))
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

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->editTitle)
            ->setInputs($this->getInputs())
            ->setData($data)
            ->setAdvancedOptions()
            ->setMaxWidth()
            ->setEdit();
        ;

        if ($noProcessed) {
            $form->addAction(new UpdateAction);
        }

        $form
            ->setList(new SaleOrderDetailList(false, $data['id'], $disable))
            ->setMaxWidth()
            ->setState(trans(config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$data['state'].'.color'));
            ;

        $actionKeys = config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route($this->getRoute().'.'.$action['key'], $data['id'])));
        }

        return $this
            ->setShortAction($this->editTitle)
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}