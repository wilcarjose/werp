<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;

class CurrencyForm extends SimplePage
{
    protected $moduleRoute = 'admin.maintenance.currencies';
    protected $mainTitle = 'Monedas';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput,
            new DescriptionInput,
            new InputBuilder('abbr', 'input', trans('view.abbr')),
            new InputBuilder('symbol', 'input', trans('view.symbol')),
            new InputBuilder('numeric_code', 'input', trans('view.numeric_code')),
        ];
    }
}