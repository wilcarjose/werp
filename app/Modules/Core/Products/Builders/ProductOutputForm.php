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
use Werp\Builders\DateBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\TextInputBuilder;
use Werp\Builders\CodeInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveActionBuilder;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\UpdateActionBuilder;
use Werp\Builders\DoctypeSelectBuilder;
use Werp\Builders\ContinueActionBuilder;
use Werp\Builders\CurrencySelectBuilder;
use Werp\Builders\CustomerSelectBuilder;
use Werp\Builders\WarehouseSelectBuilder;
use Werp\Builders\DescriptionInputBuilder;
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

            ->addInput(new DateBuilder)            
            ->addSelect(new CustomerSelectBuilder)
            ->addSelect(new WarehouseSelectBuilder)
            ->addSelect(new CurrencySelectBuilder)
            ->addInput((new DescriptionInputBuilder)->advancedOption())
            ->addInput((new TextInputBuilder('order_code', 'Código de orden'))->advancedOption()->disabled())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::IO_DOC, Config::INV_DEFAULT_IO_DOC))->advancedOption())

            ->addAction(new ContinueActionBuilder)
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

            ->addInput(new CodeInputBuilder);

        if ($data['reference']) {
            $this->addInput((new TextInputBuilder('reference', 'Referencia'))->disabled());
        }

        $this
            ->addInput((new DateBuilder)->setDisable($disable))
            ->addSelect((new CustomerSelectBuilder)->setDisable($disable))
            ->addSelect((new WarehouseSelectBuilder)->setDisable($disable))
            ->addSelect((new CurrencySelectBuilder)->setDisable($disable))
            
            ->addInput((new DescriptionInputBuilder)->advancedOption()->setDisable($disable))
            ->addInput((new TextInputBuilder('order_code', 'Código de orden'))->advancedOption()->disabled())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::IO_DOC,  Config::INV_DEFAULT_IO_DOC))->advancedOption()->setDisable($disable))

            ->setAdvancedOptions()
            ->setData($data)
            ;

        if ($noProcessed) {
            $this->addAction(new UpdateActionBuilder);
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