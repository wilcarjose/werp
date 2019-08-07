<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\DateBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\TextInputBuilder;
use Werp\Builders\CodeInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveAction;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\UpdateAction;
use Werp\Builders\DoctypeSelectBuilder;
use Werp\Builders\ContinueAction;
use Werp\Builders\CurrencySelectBuilder;
use Werp\Builders\SupplierSelectBuilder;
use Werp\Builders\WarehouseSelect;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;
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
        $this
            ->newConfig('Nueva entrada de productos')

            ->addInput(new DateBuilder)            
            ->addSelect(new SupplierSelectBuilder)
            ->addSelect(new WarehouseSelect)
            ->addInput((new DescriptionInputBuilder)->advancedOption())
            ->addInput((new TextInputBuilder('order_code', 'Código de orden'))->advancedOption()->disabled())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::IE_DOC, Config::INV_DEFAULT_IE_DOC))->advancedOption())

            ->addAction(new ContinueAction)
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
            ->editConfig('Editar entrada de productos')

            ->addInput(new CodeInputBuilder)
            ;

        if ($data['reference']) {
            $this->addInput((new TextInputBuilder('reference', 'Referencia'))->disabled());
        }

        $this
            ->addInput((new DateBuilder)->setDisable($disable))
            ->addSelect((new SupplierSelectBuilder)->setDisable($disable))
            ->addSelect((new WarehouseSelect)->setDisable($disable))
            ->addSelect((new CurrencySelectBuilder)->setDisable($disable))
            ->addInput((new AmountInputBuilder)->disabled())
            ->addInput((new AmountInputBuilder('total_tax', trans('view.total_tax')))->disabled())
            ->addInput((new AmountInputBuilder('total_discount', trans('view.total_discount')))->disabled())
            ->addInput((new AmountInputBuilder('total', trans('view.total')))->disabled())

            ->addInput((new DescriptionInputBuilder)->advancedOption()->setDisable($disable))
            ->addInput((new TextInputBuilder('order_code', 'Código de orden'))->advancedOption()->disabled())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::IE_DOC,  Config::INV_DEFAULT_IE_DOC))->advancedOption()->setDisable($disable))

            ->setAdvancedOptions()
            ->setData($data)
            ;

        if ($noProcessed) {
            $this->addAction(new UpdateAction);
        }

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