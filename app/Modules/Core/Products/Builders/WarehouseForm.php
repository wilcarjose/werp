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
use Werp\Builders\ActionBuilder;
use Werp\Builders\BreadcrumbBuilder;


class WarehouseForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), 'Home');
        $this->setTitle('Almacenes')
            ->setRoute('admin.products.warehouses')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [])
    {
        if ($action == 'edit') {
            return $this->editWarehousePage($data);
        }

        return $this->createWarehousePage();
    }

    public function createWarehousePage()
    {
        $this->setAction('Nuevo almacén')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person'))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Guardar', 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.warehouses.index')))
        ;

        return $this->view();
    }

    public function editWarehousePage($data)
    {
        $this->data = $data;

        $this->setAction('Editar almacén')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person', $data['name']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Actualizar', 'save', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.warehouses.index')))
        ;

        return $this->view();
    }
}