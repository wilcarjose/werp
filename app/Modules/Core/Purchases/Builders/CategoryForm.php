<?php

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\TabBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Actions\SaveAndNewAction;
use Werp\Builders\Actions\SaveAndEditAction;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Builders\Selects\SupplierCategorySelect;

class CategoryForm extends SimplePage
{
    protected $moduleRoute = 'admin.purchases.categories';
    protected $mainTitle = 'Categorias de proveedores';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput,
            (new SupplierCategorySelect)->setText('Categoria padre')->addNone(),
        ];
    }

    public function editPage($data)
    {
        $inputs = [
            new NameInput,
            (new SupplierCategorySelect($data['id']))->setText('Categoria padre')->addNone(),
        ];

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->editTitle)
            ->setInputs($inputs)
            ->addAction((new UpdateAction()))
            ->addAction(new SaveAndNewAction)
            ->setData($data)
            ->setEdit()
            ->setId('category');
        ;

        return $this
            ->setShortAction('Editar')
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}