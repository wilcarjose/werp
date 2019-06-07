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


class ProductForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), 'Home');
        $this->setTitle('Products')
            ->setRoute('admin.products.products')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [])
    {
        if ($action == 'edit') {
            return $this->editProductPage($data);
        }

        return $this->createProductPage();
    }

    public function createProductPage()
    {
        $this->setAction('Nuevo producto')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person'))
            ->addInput(new InputBuilder('description', 'input', 'Description', 'person'))
            ->addInput(new InputBuilder('category_id', 'input', 'Category', 'person'))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Guardar', 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.products.index')))
        ;

        return $this->view();
    }

    public function editProductPage($data)
    {
        $this->data = $data;

        $this->setAction('Editar producto')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person', $data['name']))
            ->addInput(new InputBuilder('description', 'input', 'Description', 'person', $data['description']))
            ->addInput(new InputBuilder('category_id', 'input', 'Category', 'person', $data['category_id']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Actualizar', 'save', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.products.products.index')))
        ;

        return $this->view();
    }
}