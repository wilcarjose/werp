<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\AddressInput;
use Werp\Builders\SelectBuilder;
use Werp\Builders\TextInputBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\EmailInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveActionBuilder;
use Werp\Builders\UpdateActionBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Builders\CustomerCategorySelectBuilder;


class CustomerForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'),  trans('view.dashboard'));
        $this->setTitle('Clientes')
            ->setRoute('admin.sales.customers')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage()
    {
        $this
            ->newConfig('Nuevo cliente')
            ->addInput(new TextInputBuilder('document', trans('view.document')))
            ->addInput(new NameInputBuilder())
            ->addInput(new DescriptionInputBuilder)
            ->addInput(new AddressInput)
            ->addSelect(new CustomerCategorySelectBuilder)
            ->addInput(new TextInputBuilder('contact_person', trans('view.contact_person')))
            ->addInput(new TextInputBuilder('economic_activity', trans('view.economic_activity')))
            ->addInput(new TextInputBuilder('mobile', trans('view.mobile')))
            ->addInput(new TextInputBuilder('phone', trans('view.phone')))
            ->addInput(new EmailInputBuilder)
            ->addInput(new TextInputBuilder('web', trans('view.web')))
            ->addAction(new SaveActionBuilder)
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this->data = $data;

        $this
            ->editConfig('Editar cliente')
            ->addInput(new TextInputBuilder('document', trans('view.document')))
            ->addInput(new NameInputBuilder)
            ->addInput(new DescriptionInputBuilder)
            ->addInput(new AddressInput)
            ->addSelect(new CustomerCategorySelectBuilder)
            ->addInput(new TextInputBuilder('contact_person', trans('view.contact_person')))
            ->addInput(new TextInputBuilder('economic_activity', trans('view.economic_activity')))
            ->addInput(new TextInputBuilder('mobile', trans('view.mobile')))
            ->addInput(new TextInputBuilder('phone', trans('view.phone')))
            ->addInput(new EmailInputBuilder)
            ->addInput(new TextInputBuilder('web', trans('view.web')))
            ->addAction(new UpdateActionBuilder)
            ->setData($data)
        ;

        return $this->view();
    }
}