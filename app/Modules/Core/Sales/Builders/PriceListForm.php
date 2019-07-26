<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\DateBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\InputBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\CodeInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\UpdateActionBuilder;
use Werp\Builders\ContinueActionBuilder;
use Werp\Builders\DoctypeSelectBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Builders\PriceListTypeSelectBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class PriceListForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Listas de precios')
            ->setRoute('admin.sales.price_lists')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage($dependencies = [])
    {
        $this->newConfig('Nueva lista de precio')
            ->addInput(new DateBuilder('starting_at', trans('view.from')))
            ->addSelect(new PriceListTypeSelectBuilder)
            ->addSelect(new PriceListTypeSelectBuilder(null, 'reference_price_list_type_id', 'Lista de referencia', true))
            ->addInput(new AmountInputBuilder('reference', 'Valor de referencia'))
            ->addSelect((new SelectBuilder('operation', 'Operación', config('werp.operations'), 'multiply', true)))
            ->addSelect((new SelectBuilder('round', 'Redondeo', config('werp.rounds'), 'd-2', true)))
            //->addInput(new InputBuilder('operation', 'input',  trans('view.operation')))
            //->addInput(new InputBuilder('round', 'input',  trans('view.round')))
            ->addInput((new DescriptionInputBuilder)->advancedOption())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::PL_DOC, Config::PRI_DEFAULT_PL_DOC))->advancedOption())
            ->addAction(new ContinueActionBuilder)
            //->setMaxWidth()
            ->goBackEdit()
            ->setAdvancedOptions()
        ;

        return $this->view();
    }

    public function editPage($data, $dependencies = null)
    {
        $this->data = $data;

        $disable = $data['state']['state'] != Basedoc::PE_STATE;
        $noProcessed = $data['state']['state'] == Basedoc::PE_STATE;

        $this->editConfig('Editar lista de precio')
            ->addInput((new CodeInputBuilder())->setValue($data['code']))
            ->addInput((new DateBuilder('starting_at', trans('view.from'), $data['starting_at']))->setDisable($disable))
            //->addInput((new InputBuilder('starting_at', 'input',  trans('view.from'), $data['starting_at']))->setDisable($disable))
            ->addSelect((new PriceListTypeSelectBuilder($data['price_list_type_id']))->setDisable($disable))
            ->addSelect((new PriceListTypeSelectBuilder($data['reference_price_list_type_id'], 'reference_price_list_type_id', 'Lista de referencia', true))->setDisable($disable))
            ->addInput((new AmountInputBuilder('reference', 'Valor de referencia', $data['reference']))->setDisable($disable))
            ->addSelect((new SelectBuilder('operation', 'Operación', config('werp.operations'), $data['operation'], true))->setDisable($disable))
            ->addSelect((new SelectBuilder('round', 'Redondeo', config('werp.rounds'), $data['round'], true))->setDisable($disable))
            //->addInput((new InputBuilder('operation', 'input',  trans('view.operation'), null, $data['operation']))->setDisable($disable))
            //->addInput((new InputBuilder('round', 'input',  trans('view.round'), null, $data['round']))->setDisable($disable))
            ->addInput((new DescriptionInputBuilder($data['description']))->setDisable($disable)->advancedOption())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::PL_DOC, Config::PRI_DEFAULT_PL_DOC, $data['doctype_id']))->advancedOption()->setDisable($disable))
            ->setAdvancedOptions()
            ;

        if ($noProcessed) {
            $this->addAction(new UpdateActionBuilder);
        }

        $this->setList(new PriceList(false, $data['id'], $disable))
            ->setState(trans(config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state']['state'].'.after_name')))
            ->setStateColor(config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state']['state'].'.color'))
            //->setMaxWidth()
            ;

        $actionKeys = config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state']['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$key);
            $this->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.sales.price_lists.'.$action['key'], $data['id'])));
        }

        return $this->view();
    }
}