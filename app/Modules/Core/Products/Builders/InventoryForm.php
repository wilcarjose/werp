<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\DateBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\CodeInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\UpdateAction;
use Werp\Builders\DoctypeSelectBuilder;
use Werp\Builders\ContinueAction;
use Werp\Builders\WarehouseSelectBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class InventoryForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Inventarios')
            ->setRoute('admin.products.inventories')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage($selects, $defaults)
    {
        $this
            ->newConfig('Nuevo inventario')
            ->addInput(new DateBuilder)
            ->addInput(new DescriptionInputBuilder)
            ->addSelect(new WarehouseSelectBuilder)
            ->addSelect(new DoctypeSelectBuilder(Basedoc::IN_DOC, Config::INV_DEFAULT_IN_DOC))
            ->addAction(new ContinueAction)
            //->setMaxWidth()
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
            ->editConfig('Editar inventario')
            ->addInput(new CodeInputBuilder)
            ->addInput((new DateBuilder)->setDisable($disable))
            ->addInput((new DescriptionInputBuilder)->setDisable($disable))
            ->addSelect((new WarehouseSelectBuilder)->setDisable($disable))
            ->addSelect((new DoctypeSelectBuilder(Basedoc::IN_DOC, Config::INV_DEFAULT_IN_DOC))->setDisable($disable))
            ->setData($data)
            ->setAdvancedOptions();

        if ($noProcessed) {
            $this->addAction(new UpdateAction);
        }

        $this
            ->setList(new InventoryDetailList(false, $data['id'], $disable))
            //->setMaxWidth()
            ->setState(trans(config('products.document.actions.'.Basedoc::IN_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IN_DOC.'.'.$data['state'].'.color'));
        ;

        $actionKeys = config('products.document.actions.'.Basedoc::IN_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IN_DOC.'.'.$key);
            $this->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.products.inventories.'.$action['key'], $data['id'])));
        }

        return $this->view();
    }
}