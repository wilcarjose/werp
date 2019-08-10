<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Inputs\NameInput;
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
        ];
    }
}