<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;

class BrandForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.brands';
    protected $mainTitle = 'Marcas';
    protected $newTitle = 'Nueva';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput,
            new DescriptionInput,
            new InputBuilder('country', trans('view.country')),
        ];
    }
}