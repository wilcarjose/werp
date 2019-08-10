<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\DateInput;
use Werp\Builders\FormBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\CodeInput;
use Werp\Builders\TextInput;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\UpdateAction;
use Werp\Builders\DoctypeSelect;
use Werp\Builders\ContinueAction;
use Werp\Builders\WarehouseSelect;
use Werp\Builders\DescriptionInput;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class MovementForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Movimiento de inventario')
            ->setRoute('admin.products.movements')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage($selects, $defaults)
    {
        $this
            ->newConfig('Nuevo movimiento')
            ->addInput(new DateInput)
            ->addInput(new DescriptionInput)
            ->addSelect(new WarehouseSelect('warehouse_from_id', trans('view.from')))
            ->addSelect(new WarehouseSelect('warehouse_to_id', trans('view.to')))
            ->addSelect(new DoctypeSelect(Basedoc::IM_DOC, Config::INV_DEFAULT_IM_DOC))
            ->addAction(new ContinueAction)
            ->goBackEdit()
            ->setAdvancedOptions()
        ;

        return $this->view();
    }

    public function editPage($data, $selects = null)
    {
        $this->data = $data;

        $disable = $data['state'] != Basedoc::PE_STATE;
        $noProcessed = $data['state'] == Basedoc::PE_STATE;

        $this
            ->editConfig('Editar movimiento')
            ->addInput(new CodeInput);

        if ($data['reference']) {
            $this->addInput((new TextInput('reference', 'Referencia'))->disabled());
        }

        $this
            ->addInput((new DateInput)->setDisable($disable))
            ->addInput((new DescriptionInput)->setDisable($disable))
            ->addSelect((new WarehouseSelect('warehouse_from_id', trans('view.from')))->setDisable($disable))
            ->addSelect((new WarehouseSelect('warehouse_to_id', trans('view.to')))->setDisable($disable))
            ->addSelect((new DoctypeSelect(Basedoc::IM_DOC, Config::INV_DEFAULT_IM_DOC))->setDisable($disable))
            ->setData($data)
            ->setAdvancedOptions();

        if ($noProcessed) {
            $this->addAction(new UpdateAction);
        }

        $this
            ->setList(new MovementDetailList(false, $data['id'], $disable))
            ->setState(trans(config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.color'));
        ;

        $actionKeys = config('products.document.actions.'.Basedoc::IM_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IM_DOC.'.'.$key);
            $this->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route($this->getRoute().'.'.$action['key'], $data['id'])));
        }

        return $this->view();
    }
}