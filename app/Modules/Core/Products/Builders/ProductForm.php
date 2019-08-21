<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\Files\ExcelFile;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Selects\UomSelect;
use Werp\Builders\Selects\BrandSelect;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Actions\ImportAction;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Builders\Selects\ProductCategorySelect;
use Werp\Builders\Selects\SupplierSelectBuilder;

class ProductForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.products';
    protected $mainTitle = 'Productos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new InputBuilder('code', trans('view.code')),
            new NameInput,
            new DescriptionInput,
            new InputBuilder('part_number', trans('view.products.part_number')),
            new UomSelect,
            new BrandSelect,
            new ProductCategorySelect,
            new SupplierSelectBuilder,
            new InputBuilder('barcode', trans('view.products.barcode')),
            new InputBuilder('link', trans('view.products.link')),
        ];
    }

    public function importPage()
    {
        $inputs = [
            new ExcelFile,
        ];

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setMainRoute('import')
            ->setAction($this->newTitle)
            ->setInputs($inputs)
            ->addAction(new ImportAction)
        ;

        return $this
            ->setShortAction('Importar')
            ->newConfig()
            ->addForm($form)->view()
        ;
    }
}