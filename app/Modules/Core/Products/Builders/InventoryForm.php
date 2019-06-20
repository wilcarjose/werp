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

class InventoryForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Inventarios')
            ->setRoute('admin.products.inventories')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [], $selects = [])
    {
        if ($action == 'edit') {
            return $this->editProductPage($data, $selects = []);
        }

        return $this->createProductPage($selects = []);
    }

    public function createInventoryPage($selects = null)
    {
        $this->setAction('Nuevo inventario')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('code', 'input', 'Código', null, null, true))
            ->addInput(new InputBuilder('description', 'textarea', 'Descripción'))
            ->addSelect(new SelectBuilder('warehouse_id', 'select', 'Almacén', null, $selects['warehouses']))
            ->addSelect(new SelectBuilder('doctype_id', 'select', 'Tipo de Documento', null, $selects['doctypes']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.inventories.index')))
            //->addList(new InventoryDetailList(true))
            ->setMaxWidth()
        ;

        return $this->view();
    }

    public function editInventoryPage($data, $selects = null)
    {
        $this->data = $data;

        $disable = $data['state'] != 'pe';
        $noProcessed = $data['state'] == 'pe';

        $this->setAction('Editar inventario')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('code', 'input', 'Código', null, $data['code'], true))
            ->addInput(new InputBuilder('description', 'textarea', 'Descripción', null, $data['description'], $disable))
            ->addSelect(new SelectBuilder('warehouse_id', 'select', 'Almacén', null, $selects['warehouses'], $data['warehouse_id'], $disable))
            ->addSelect(new SelectBuilder('doctype_id', 'select', 'Tipo de Documento', null, $selects['doctypes'], $data['doctype_id'], $disable));

        if ($noProcessed) {
            $this->addAction(new ActionBuilder('save', ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'));
        }

        //$this->addAction(new ActionBuilder('cancel', ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.inventories.index')));

        $this->addList(new InventoryDetailList(false, $data['id'], $disable))
            ->setMaxWidth()
            ->setState(trans(config('products.document.actions.inv.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.inv.'.$data['state'].'.color'));
        ;

        $actionKeys = config('products.document.actions.inv.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.inv.'.$key);
            $this->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.products.inventories.'.$action['key'], $data['id'])));
        }

        return $this->view();
    }
}