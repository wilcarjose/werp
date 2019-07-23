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


class BrandForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'),  trans('view.dashboard'));
        $this->setTitle('Marcas')
            ->setRoute('admin.products.brands')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [])
    {
        if ($action == 'edit') {
            return $this->editPage($data);
        }

        return $this->createPage();
    }

    public function createPage()
    {
        $this->setAction('Nueva marca')
            ->setShortAction('Nueva')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('name', 'input', trans('view.name')))
            ->addInput(new InputBuilder('description', 'textarea',  trans('view.description')))
            ->addInput(new InputBuilder('country', 'input', trans('view.country')))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.brands.index')))
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this->data = $data;

        $this->setAction('Editar marca')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('name', 'input', trans('view.name'), null, $data['name']))
            ->addInput(new InputBuilder('description', 'textarea',  trans('view.description'), null, $data['description']))
            ->addInput(new InputBuilder('country', 'input', trans('view.country'), null, $data['country']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'))
            //->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.brands.index')))
        ;

        return $this->view();
    }
}