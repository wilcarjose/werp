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
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\DoctypeSelectBuilder;
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
        $this->setAction('Nuevo inventario')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            //->addInput(new InputBuilder('code', 'input', 'Código', null, null, true))
            ->addInput(new InputBuilder('description', 'textarea', 'Descripción'))
            ->addSelect(new SelectBuilder('warehouse_id', 'Almacén', $selects['warehouses'], $defaults['warehouse']))
            ->addSelect(new DoctypeSelectBuilder(Basedoc::IN_DOC, 'inv_default_inventory_doctype'))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            //->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.inventories.index')))
            //->setList(new InventoryDetailList(true))
            ->setMaxWidth()
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

        $this->setAction('Editar inventario')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('code', 'code', 'Código', null, $data['code'], true))
            ->addInput(new InputBuilder('description', 'textarea', 'Descripción', null, $data['description'], $disable))
            ->addSelect(new SelectBuilder('warehouse_id', 'Almacén', $selects['warehouses'], $data['warehouse_id'], false, $disable))
            ->addSelect(new DoctypeSelectBuilder(Basedoc::IN_DOC, 'inv_default_inventory_doctype', $data['doctype_id']))
            ->setAdvancedOptions();

        if ($noProcessed) {
            $this->addAction(new ActionBuilder('save', ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'));
        }

        //$this->addAction(new ActionBuilder('cancel', ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.inventories.index')));

        $this
            ->setList(new InventoryDetailList(false, $data['id'], $disable))
            ->setMaxWidth()
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