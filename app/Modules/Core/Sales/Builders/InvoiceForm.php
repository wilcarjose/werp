<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Selects\TaxSelect;
use Werp\Builders\Inputs\DateInput;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Selects\DiscountSelect;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\PaymentMethodSelect;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Selects\CustomerSelectBuilder;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class InvoiceForm extends SimplePage
{
    protected $moduleRoute = 'admin.sales.invoices';
    protected $mainTitle = 'Factura de venta';
    protected $newTitle = 'Nueva';
    protected $editTitle = 'Editar';

    protected function getInputs($new = false)
    {
        if (!$new) {
            //$inputs[] = new CodeInput;
        }

        $inputs[] = new InputBuilder('number', trans('view.number'));
        $inputs[] = new DateInput;
        $inputs[] = new CurrencySelect;
        $inputs[] = new CustomerSelectBuilder;
        $inputs[] = new TaxSelect;
        $inputs[] = new DiscountSelect;
        $inputs[] = (new PaymentMethodSelect)->setNone(true);
        $inputs[] = (new DescriptionInput)->advancedOption();
        $inputs[] = (new DoctypeSelect(
            Basedoc::SI_DOC,
            Config::SAL_DEFAULT_SI_DOC
        ))->advancedOption();

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
            ->setWidth('s10 push-m1')
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
            ->setAction('Factura # '. $data['number'])
            ->setInputs($this->getInputs())
            ->setData($data)
            ->setAdvancedOptions()
            ->setEdit();
        ;

        if ($noProcessed) {
            $form->addAction(new UpdateAction);
        }

        $form
            ->setWidth('s10 push-m1')
            ->setState(trans(config('sales.document.actions.'.Basedoc::SI_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('sales.document.actions.'.Basedoc::SI_DOC.'.'.$data['state'].'.color'));
            ;

        $actionKeys = config('sales.document.actions.'.Basedoc::SI_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('sales.document.actions.'.Basedoc::SI_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route($this->getRoute().'.'.$action['key'], $data['id'])));
        }

        return $this
            ->addList(new InvoiceLinesList(false, $data['id'], $disable))
            ->setListsWidth('s10 push-m1')
            ->setMessagesWidth('s10 push-m1')
            ->setShortAction($this->editTitle)
            ->editConfig()
            //->setWidth('s10 push-m1')
            ->addForm($form)->view()
        ;
    }
}
