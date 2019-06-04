<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\InputBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\BreadcrumbBuilder;


class CategoryForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), 'Home');
        $this->setTitle('Categorias')
            ->setRoute('admin.categories')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [])
    {
        if ($action == 'edit') {
            return $this->editCategoryPage($data);
        }

        return $this->createCategoryPage();
    }

    public function createCategoryPage()
    {
        $this->setAction('Nueva categoria')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person'))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Guardar', 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.categories.index')))
        ;

        return $this->view();
    }

    public function editCategoryPage($data)
    {
        $this->data = $data;

        $this->setAction('Editar categoria')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person', $data['name']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Actualizar', 'save', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.categories.index')))
        ;

        return $this->view();
    }
}