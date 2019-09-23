<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\Files\SqlFile;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Actions\ImportAction;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\DescriptionInput;

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
        $this->addForm($this->configValuesForm())
            ->addForm($this->importPage())
            ->addForm($this->updateProductionForm())
            ;

        return $this->view();
    }

    protected function configValuesForm()
    {
        $form = new FormBuilder;

        $form->setAction('Actualizar base de datos de pruebas con la base de datos de producción')
            ->setEdit()
            ->setRoute('admin.maintenance.db_test')
            ->setInputs([])
            ->addAction(new UpdateAction())
        ;

        return $form;
    }

    public function importPage()
    {
        $inputs = [
            (new SqlFile)->setWidth('l12'),
        ];

        return (new FormBuilder)
            ->setRoute('admin.maintenance.db_test')
            ->setMainRoute('update-from-sql')
            ->setAction('Actualizar base de datos de pruebas desde archivo .sql')
            ->setInputs($inputs)
            ->addAction(new UpdateAction)
        ;
    }

    protected function updateProductionForm()
    {
        $form = new FormBuilder;

        $form->setAction('Actualizar base de datos de producción desde base de datos de pruebas (se hará un respaldo automático de la base de datos de producción)')
            ->setRoute('admin.maintenance.db_test')
            ->setMainRoute('update-production-from-test')
            ->addAction(new UpdateAction())
        ;

        return $form;
    }
}