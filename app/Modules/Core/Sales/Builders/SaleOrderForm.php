<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\TaxSelect;
use Werp\Builders\FormSelect;
use Werp\Builders\FormBuilder;
use Werp\Builders\DateBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\DiscountSelect;
use Werp\Builders\TextInputBuilder;
use Werp\Builders\CodeInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveActionBuilder;
use Werp\Builders\SaleChannelSelect;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\UpdateActionBuilder;
use Werp\Builders\PaymentMethodSelect;
use Werp\Builders\DoctypeSelectBuilder;
use Werp\Builders\CustomerSelectBuilder;
use Werp\Builders\ContinueActionBuilder;
use Werp\Builders\CurrencySelectBuilder;
use Werp\Builders\WarehouseSelectBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Builders\PriceListTypeSelectBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class SaleOrderForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Orden de venta')
            ->setRoute('admin.sales.orders')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage($selects, $defaults)
    {
        $this
            ->newConfig('Crear nueva')

            ->addInput(new DateBuilder)            
            ->addSelect(new CustomerSelectBuilder)
            ->addSelect(new PriceListTypeSelectBuilder)
            ->addSelect(new WarehouseSelectBuilder)
            ->addSelect(new SaleChannelSelect)
            ->addSelect((new TaxSelect))
            ->addSelect((new DiscountSelect))
            ->addSelect((new PaymentMethodSelect)->setNone(true))
            ->addInput((new DescriptionInputBuilder)->advancedOption())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::SO_DOC, Config::INV_DEFAULT_SO_DOC))->advancedOption())

            ->addAction(new ContinueActionBuilder)
            ->goBackEdit()
            
            //->setGoBack('edit')
            //->goBackHome()
            //->goBackEdit()
            //->goBackNew()
            //->goBackList()

            //->setMaxWidth()
            ->setAdvancedOptions()
            ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this->data = $data;

        $disable = $data['state'] != Basedoc::PE_STATE;
        $noProcessed = $data['state'] == Basedoc::PE_STATE;

        $this
            ->editConfig('Editar')

            ->addInput(new CodeInputBuilder)
            ;

        if ($data['reference']) {
            $this->addInput((new TextInputBuilder('reference', 'Referencia'))->disabled());
        }

        $this
            ->addInput((new DateBuilder)->setDisable($disable))
            ->addSelect((new CustomerSelectBuilder)->setDisable($disable))
            ->addSelect((new PriceListTypeSelectBuilder)->setDisable($disable))
            ->addSelect((new WarehouseSelectBuilder)->setDisable($disable))
            ->addSelect((new SaleChannelSelect)->setDisable($disable))
            ->addSelect((new TaxSelect)->setDisable($disable))
            ->addSelect((new DiscountSelect)->setDisable($disable))
            ->addSelect((new PaymentMethodSelect)->setDisable($disable))
            //->addSelect((new CurrencySelectBuilder)->setDisable($disable))

            ->addInput((new DescriptionInputBuilder)->advancedOption()->setDisable($disable))
            ->addSelect((new DoctypeSelectBuilder(Basedoc::SO_DOC,  Config::INV_DEFAULT_SO_DOC))->advancedOption()->setDisable($disable))

            ->setAdvancedOptions()
            ->setData($data)
            ;

        if ($noProcessed) {
            $this->addAction(new UpdateActionBuilder);
        }

        $this
            ->setList(new SaleOrderDetailList(false, $data['id'], $disable))
            ->setMaxWidth()
            ->setState(trans(config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$data['state'].'.color'));
            ;

        $actionKeys = config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('sales.document.actions.'.Basedoc::SO_DOC.'.'.$key);
            $this->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route($this->getRoute().'.'.$action['key'], $data['id'])));
        }

        return $this->view();
    }
}