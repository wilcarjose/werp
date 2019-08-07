<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\BrandSelect;
use Werp\Builders\DateBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\UpdateAction;
use Werp\Builders\InputBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\ContinueAction;
use Werp\Builders\OperationSelect;
use Werp\Builders\WarehouseSelect;
use Werp\Builders\CodeInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\ProductCategorySelect;
use Werp\Builders\DoctypeSelectBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Builders\PriceListTypeSelectBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class PriceListForm extends FormBuilder
{
    protected $moduleRoute = 'admin.sales.price_lists';

    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Listas de precios')
            ->setRoute($this->moduleRoute)
            ->addBreadcrumb($homeBreadcrumb);

        $this->listRoute = $this->moduleRoute.'.index';
    }

    public function createPage($dependencies = [])
    {
        $this->newConfig('Nueva lista de precio')
            ->addInput(new DateBuilder('starting_at', trans('view.from')))
            ->addSelect((new PriceListTypeSelectBuilder)->setText('Lista a generar'))
            ->addSelect(new PriceListTypeSelectBuilder(null, 'reference_price_list_type_id', 'Lista precio base', true))
            ->addSelect(new OperationSelect)
            ->addInput((new DescriptionInputBuilder)->advancedOption())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::PL_DOC, Config::PRI_DEFAULT_PL_DOC))->advancedOption())
            ->addAction(new ContinueAction)
            ->setMaxWidth()
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
            ->addSelect((new PriceListTypeSelectBuilder($data['price_list_type_id']))->setText('Lista a generar')->setDisable($disable))
            ->addSelect((new PriceListTypeSelectBuilder($data['reference_price_list_type_id'], 'reference_price_list_type_id', 'Lista precio base', true))->setDisable($disable))
            ->addSelect((new OperationSelect)->setDisable($disable))
            ->addInput((new DescriptionInputBuilder($data['description']))->setDisable($disable)->advancedOption())
            ->addSelect((new DoctypeSelectBuilder(Basedoc::PL_DOC, Config::PRI_DEFAULT_PL_DOC, $data['doctype_id']))->advancedOption()->setDisable($disable))
            ->setAdvancedOptions()
            ->setFilter('admin.core.sales.filters.price_list')
            ->addFilters((new WarehouseSelect))
            ->addFilters((new ProductCategorySelect))
            ->addFilters((new BrandSelect))
            ->setData($data)
            ->setMaxWidth()
            ;

        if ($noProcessed) {
            $this->addAction(new UpdateAction);
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