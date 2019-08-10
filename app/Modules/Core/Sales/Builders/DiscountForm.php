<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Selects\OperationSelect;
use Werp\Builders\Inputs\NameInput;;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;

class DiscountForm extends SimplePage
{
    protected $moduleRoute = 'admin.sales.discounts';
    protected $mainTitle = 'Descuentos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput,
            new DescriptionInput,
            new OperationSelect,
        ];
    }
}