<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;

class UomForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.uom';
    protected $mainTitle = 'Unidades de medidas';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput,
            new InputBuilder('abbr', trans('view.abbr')),
            new InputBuilder('symbol', trans('view.symbol')),
            new DescriptionInput,
        ];
    }
}