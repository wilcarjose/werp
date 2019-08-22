<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Selects\CurrencySelect;

class CompanyForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Empresa')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('admin.maintenance.company.edit', 'Empresa'));
    }

    public function editPage($data)
    {
        $this->addForm($this->getConfigValuesForm($data));

        return $this->view();
    }

    protected function getConfigValuesForm($data)
    {
        $form = new FormBuilder;

        $form->setAction('Empresa')
            ->setEdit()
            ->setRoute('admin.maintenance.company')
            //->setMiddleWidth()
            ->addInput(new NameInput)
            ->addInput(new DescriptionInput)
            ->addInput(new InputBuilder('document', 'Documento'))
            ->addInput(new InputBuilder('document2', 'Documento adicional'))
            ->addInput(new InputBuilder('phone1', 'Teléfono'))
            ->addInput(new InputBuilder('phone2', 'Teléfono 2'))
            ->addInput(new InputBuilder('phone3', 'Teléfono 3'))
            ->addInput(new InputBuilder('email', 'Email'))
            ->setData($data)
            ->addAction(new UpdateAction())
        ;

        

        return $form;
    }
}