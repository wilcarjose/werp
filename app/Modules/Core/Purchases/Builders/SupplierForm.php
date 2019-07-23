<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\TextInputBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\EmailInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\DescriptionInputBuilder;


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
            ->addInput(new TextInputBuilder('document', trans('view.document')))
            ->addInput(new NameInputBuilder())
            ->addInput(new DescriptionInputBuilder())
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), $selects['categories']))
            ->addInput(new TextInputBuilder('contact_person', trans('view.contact_person')))
            ->addInput(new TextInputBuilder('economic_activity', trans('view.economic_activity')))
            ->addInput(new TextInputBuilder('mobile', trans('view.mobile')))
            ->addInput(new TextInputBuilder('phone', trans('view.phone')))
            ->addInput(new EmailInputBuilder())
            ->addInput(new TextInputBuilder('web', trans('view.web')))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            //->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.purchases.suppliers.index')))
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
            ->addInput(new TextInputBuilder('document', trans('view.document'), $data['document']))
            ->addInput(new NameInputBuilder($data['name']))
            ->addInput(new DescriptionInputBuilder($data['description']))
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), $selects['categories'], $data['category_id']))
            ->addInput(new TextInputBuilder('contact_person', trans('view.contact_person'), $data['contact_person']))
            ->addInput(new TextInputBuilder('economic_activity', trans('view.economic_activity'), $data['economic_activity']))
            ->addInput(new TextInputBuilder('mobile', trans('view.mobile'), $data['mobile']))
            ->addInput(new TextInputBuilder('phone', trans('view.phone'), $data['phone']))
            ->addInput(new TextInputBuilder('email', trans('view.email'), $data['email']))
            ->addInput(new TextInputBuilder('web', trans('view.web'), $data['web']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'))
            //->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.purchases.suppliers.index')))
        ;

        return $this->view();
    }
}