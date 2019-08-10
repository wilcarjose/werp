<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\PrintAction;
use Werp\Builders\FormBuilder;
use Werp\Builders\DateInput;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\TextInput;
use Werp\Builders\CodeInput;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveAction;
use Werp\Builders\AmountInput;
use Werp\Builders\UpdateAction;
use Werp\Builders\DoctypeSelect;
use Werp\Builders\ContinueAction;
use Werp\Builders\CurrencySelectBuilder;
use Werp\Builders\CustomerSelectBuilder;
use Werp\Builders\WarehouseSelect;
use Werp\Builders\DescriptionInput;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class ProductOutputForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Notas de entregas')
            ->setRoute('admin.products.product_output')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage()
    {
        $this
            ->newConfig('Nueva')

            ->addInput(new DateInput)            
            ->addSelect(new CustomerSelectBuilder)
            ->addSelect(new WarehouseSelect)
            ->addSelect(new CurrencySelectBuilder)
            ->addInput((new DescriptionInput)->advancedOption())
            ->addInput((new TextInput('order_code', 'Código de orden'))->advancedOption()->disabled())
            ->addSelect((new DoctypeSelect(Basedoc::IO_DOC, Config::INV_DEFAULT_IO_DOC))->advancedOption())

            ->addAction(new ContinueAction)
            ->goBackEdit()
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

            ->addInput(new CodeInput);

        if ($data['reference']) {
            $this->addInput((new TextInput('reference', 'Referencia'))->disabled());
        }

        $this
            ->addInput((new DateInput)->setDisable($disable))
            ->addSelect((new CustomerSelectBuilder)->setDisable($disable))
            ->addSelect((new WarehouseSelect)->setDisable($disable))
            ->addSelect((new CurrencySelectBuilder)->setDisable($disable))
            
            ->addInput((new DescriptionInput)->advancedOption()->setDisable($disable))
            ->addInput((new TextInput('order_code', 'Código de orden'))->advancedOption()->disabled())
            ->addSelect((new DoctypeSelect(Basedoc::IO_DOC,  Config::INV_DEFAULT_IO_DOC))->advancedOption()->setDisable($disable))

            ->setAdvancedOptions()
            ->setData($data)
            ;

        if ($noProcessed) {
            $this->addAction(new UpdateAction);
        }

        $this
            ->setList(new ProductOutputDetailList(false, $data['id'], $disable))
            ->setMaxWidth()
            ->setState(trans(config('products.document.actions.'.Basedoc::IO_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IO_DOC.'.'.$data['state'].'.color'))
            ->setPrintAction((new PrintAction)->setRoute(route($this->getRoute().'.print', $data['id'])))
        ;

        $actionKeys = config('products.document.actions.'.Basedoc::IO_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IO_DOC.'.'.$key);
            $this->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.products.product_output.'.$action['key'], $data['id'])));
        }

        return $this->view();
    }
}