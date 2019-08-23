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

class DataTestForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Datos de pruebas')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('edit', 'Datos de pruebas'));
    }

    public function editPage()
    {
        $this->addForm($this->getConfigValuesForm());

        return $this->view();
    }

    protected function getConfigValuesForm()
    {
        $form = new FormBuilder;

        $form->setAction('Actualizar base de datos de pruebas con datos actuales')
            ->setEdit()
            ->setRoute('admin.maintenance.db_test')
            ->setInputs([])
            ->addAction(new UpdateAction())
        ;

        return $form;
    }
}