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


class ProductForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), 'Home');
        $this->setTitle('Products')
            ->setRoute('admin.products.products')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [], $selects = [])
    {
        if ($action == 'edit') {
            return $this->editProductPage($data, $selects = []);
        }

        return $this->createProductPage($selects = []);
    }

    public function createProductPage($selects = null)
    {
        $this->setAction('Nuevo producto')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person'))
            ->addInput(new InputBuilder('description', 'input', 'Description', 'person'))
            ->addSelect(new SelectBuilder('category_id', 'select', 'Categoría', 'person', $selects['categories']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Guardar', 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.products.index')))
        ;

        return $this->view();
    }

    public function editProductPage($data, $selects = null)
    {
        $this->data = $data;

        $this->setAction('Editar producto')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person', $data['name']))
            ->addInput(new InputBuilder('description', 'input', 'Description', 'person', $data['description']))
            ->addSelect(new SelectBuilder('category_id', 'select', 'Category', 'person', $selects['categories'], $data['category_id']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Actualizar', 'save', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.products.index')))
        ;

        return $this->view();
    }
}