<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\InputBuilder;
use Werp\Builders\CodeInputBuilder;
use Werp\Builders\DateBuilder;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\SupplierSelectBuilder;
use Werp\Builders\WarehouseSelectBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\DoctypeSelectBuilder;
use Werp\Builders\CurrencySelectBuilder;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class ProductEntryForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Entrada de productos')
            ->setRoute('admin.products.product_entry')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage($selects, $defaults)
    {
        $this->setAction('Nueva entrada de productos')
            ->setShortAction('Nueva')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))

            ->addInput(new CodeInputBuilder)
            ->addInput(new DateBuilder)

            /*
            ->addInput(new AmountInputBuilder)
            ->addInput(new AmountInputBuilder())
            ->addInput(new AmountInputBuilder())
            ->addInput(new AmountInputBuilder())
            ->addInput(new CurrencySelectBuilder)
            */
            
            ->addSelect(new SupplierSelectBuilder)
            ->addSelect(new WarehouseSelectBuilder)

            ->addInput((new DescriptionInputBuilder)->advancedOption())
            ->addInput((new InputBuilder('order_code', 'input', 'Código de orden'))->advancedOption()->setDisable(true))
            ->addSelect((new DoctypeSelectBuilder(Basedoc::IE_DOC, 'inv_default_ie_doc'))->advancedOption())

            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            //->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.product_entry.index')))
            //->setList(new InventoryDetailList(true))
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

        $this->setAction('Editar entrada de productos')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()

            ->addInput(new CodeInputBuilder)
            ->addInput((new DateBuilder)->setDisable($disable))

            ->addSelect((new SupplierSelectBuilder)->setDisable($disable))
            ->addSelect((new WarehouseSelectBuilder)->setDisable($disable))
            ->addSelect((new CurrencySelectBuilder)->setDisable($disable))

            ->addInput((new AmountInputBuilder)->setDisable(true))
            ->addInput((new AmountInputBuilder('tax_amount', trans('view.tax_amount')))->setDisable(true))
            ->addInput((new AmountInputBuilder('discount_amount', trans('view.discount_amount')))->setDisable(true))
            ->addInput((new AmountInputBuilder('total_amount', trans('view.total_amount')))->setDisable(true))
            

            ->addInput((new DescriptionInputBuilder)->advancedOption()->setDisable($disable))
            ->addInput((new InputBuilder('order_code', 'input', 'Código de orden'))->advancedOption()->setDisable(true))
            ->addSelect((new DoctypeSelectBuilder(Basedoc::IE_DOC, 'inv_default_ie_doc'))->advancedOption()->setDisable($disable))

            ->setAdvancedOptions()
            ->setData($data)
            ;

        if ($noProcessed) {
            $this->addAction(new ActionBuilder('save', ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'));
        }

        //$this->addAction(new ActionBuilder('cancel', ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.product_entry.index')));

        $this
            ->setList(new ProductEntryDetailList(false, $data['id'], $disable))
            ->setMaxWidth()
            ->setState(trans(config('products.document.actions.'.Basedoc::IE_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IE_DOC.'.'.$data['state'].'.color'));
        ;

        $actionKeys = config('products.document.actions.'.Basedoc::IE_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IE_DOC.'.'.$key);
            $this->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.products.product_entry.'.$action['key'], $data['id'])));
        }

        return $this->view();
    }
}