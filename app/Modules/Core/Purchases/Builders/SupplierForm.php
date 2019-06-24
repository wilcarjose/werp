<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\InputBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\BreadcrumbBuilder;


class SupplierForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'),  trans('view.dashboard'));
        $this->setTitle('Proveedores')
            ->setRoute('admin.purchases.suppliers')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [])
    {
        if ($action == 'edit') {
            return $this->editPage($data);
        }

        return $this->createPage();
    }

    public function createPage($selects)
    {
        $this->setAction('Nuevo proveedor')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('document', 'input', trans('view.document')))
            ->addInput(new InputBuilder('name', 'input', trans('view.name')))
            ->addInput(new InputBuilder('description', 'textarea', trans('view.description')))
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), null, $selects['categories']))
            ->addInput(new InputBuilder('contact_person', 'input', trans('view.contact_person')))
            ->addInput(new InputBuilder('economic_activity', 'input', trans('view.economic_activity')))
            ->addInput(new InputBuilder('mobile', 'input', trans('view.mobile')))
            ->addInput(new InputBuilder('phone', 'input', trans('view.phone')))
            ->addInput(new InputBuilder('email', 'input', trans('view.email')))
            ->addInput(new InputBuilder('web', 'input', trans('view.web')))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.purchases.suppliers.index')))
        ;

        return $this->view();
    }

    public function editPage($data, $selects)
    {
        $this->data = $data;

        $this->setAction('Editar proveedor')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('document', 'input', trans('view.document'), null, $data['document']))
            ->addInput(new InputBuilder('name', 'input', trans('view.name'), null, $data['name']))
            ->addInput(new InputBuilder('description', 'textarea', trans('view.description'), null, $data['description']))
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), null, $selects['categories'], $data['category_id']))
            ->addInput(new InputBuilder('contact_person', 'input', trans('view.contact_person'), null, $data['contact_person']))
            ->addInput(new InputBuilder('economic_activity', 'input', trans('view.economic_activity'), null, $data['economic_activity']))
            ->addInput(new InputBuilder('mobile', 'input', trans('view.mobile'), null, $data['mobile']))
            ->addInput(new InputBuilder('phone', 'input', trans('view.phone'), null, $data['phone']))
            ->addInput(new InputBuilder('email', 'input', trans('view.email'), null, $data['email']))
            ->addInput(new InputBuilder('web', 'input', trans('view.web'), null, $data['web']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.purchases.suppliers.index')))
        ;

        return $this->view();
    }
}