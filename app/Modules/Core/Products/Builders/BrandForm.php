<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\InputBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Base\Builders\SimpleBaseForm;

class BrandForm extends SimpleBaseForm
{
    protected $moduleRoute = 'admin.products.brands';
    protected $mainTitle = 'Marcas';
    protected $newTitle = 'Nueva';
    protected $editTitle = 'Editar';

    protected function makeInputs()
    {
        return $this
            ->addInput(new NameInputBuilder)
            ->addInput(new DescriptionInputBuilder)
            ->addInput(new InputBuilder('country', 'input', trans('view.country')))
        ;
    }
}