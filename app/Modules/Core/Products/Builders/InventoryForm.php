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
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), 'Home');
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
            ->addInput(new InputBuilder('code', 'input', 'Código', 'person', null, true))
            ->addInput(new InputBuilder('description', 'textarea', 'Description', 'person'))
            ->addSelect(new SelectBuilder('warehouse_id', 'select', 'Almacén', 'person', $selects['warehouses']))
            ->addSelect(new SelectBuilder('doctype_id', 'select', 'Tipo de Documento', 'person', $selects['doctypes']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Guardar', 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.inventories.index')))
            //->addList(new InventoryDetailList(true))
            ->setMaxWidth()
        ;

        return $this->view();
    }

    public function editInventoryPage($data, $selects = null)
    {
        $this->data = $data;

        $this->setAction('Editar inventario')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('code', 'input', 'Código', 'person', $data['code'], true))
            ->addInput(new InputBuilder('description', 'textarea', 'Description', 'person', $data['description']))
            ->addSelect(new SelectBuilder('warehouse_id', 'select', 'Almacén', 'person', $selects['warehouses'], $data['warehouse_id']))
            ->addSelect(new SelectBuilder('doctype_id', 'select', 'Tipo de Documento', 'person', $selects['doctypes'], $data['doctype_id']))
            ->addAction(new ActionBuilder('process', ActionBuilder::TYPE_LINK, 'Procesar', '', 'button', route('admin.products.inventories.process', $data['id'])))
            ->addAction(new ActionBuilder('save', ActionBuilder::TYPE_BUTTON, 'Actualizar', 'save', 'submit'))
            ->addAction(new ActionBuilder('cancel', ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.inventories.index')))
            ->addList(new InventoryDetailList(false, $data['id']))
            ->setMaxWidth()
        ;

        return $this->view();
    }
}