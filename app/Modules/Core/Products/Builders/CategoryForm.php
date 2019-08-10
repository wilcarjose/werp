<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Actions\SaveAndNewAction;
use Werp\Builders\Selects\ProductCategorySelect;
use Werp\Modules\Core\Base\Builders\SimplePage;

class CategoryForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.categories';
    protected $mainTitle = 'Categorias de productos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput,
            (new ProductCategorySelect)->setText('Categoria padre')->addNone(),
        ];
    }

    public function editPage($data)
    {
        $inputs = [
            new NameInput,
            (new ProductCategorySelect($data['id']))->setText('Categoria padre')->addNone(),
        ];

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->editTitle)
            ->setInputs($inputs)
            ->addAction(new UpdateAction)
            ->addAction(new SaveAndNewAction)
            ->setData($data)
            ->setEdit();
        ;

        return $this
            ->setShortAction('Editar')
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}