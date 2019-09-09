<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\ColorInput;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Modules\Core\Base\Builders\SimplePage;

class WarehouseForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.warehouses';
    protected $mainTitle = 'Almacenes';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput,
            new InputBuilder('abbr', trans('view.abbr')),
            new ColorInput,
        ];
    }
}