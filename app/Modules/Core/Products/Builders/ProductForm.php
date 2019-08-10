<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Selects\UomSelect;
use Werp\Builders\Selects\BrandSelect;
use Werp\Builders\Selects\ProductCategorySelect;
use Werp\Builders\Selects\SupplierSelectBuilder;
use Werp\Modules\Core\Base\Builders\SimplePage;


class ProductForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.products';
    protected $mainTitle = 'Productos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new InputBuilder('code', 'input',  trans('view.code')),
            new NameInput,
            new DescriptionInput,
            new InputBuilder('part_number', 'input',  trans('view.products.part_number')),
            new UomSelect,
            new BrandSelect,
            new ProductCategorySelect,
            (new SupplierSelectBuilder)->advancedOption(),
            (new InputBuilder('barcode', 'input',  trans('view.products.barcode')))->advancedOption(),
            (new InputBuilder('link', 'input',  trans('view.products.link')))->advancedOption(),
        ];
    }
}