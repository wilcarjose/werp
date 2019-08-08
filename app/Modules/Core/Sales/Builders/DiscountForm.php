<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\OperationSelect;
use Werp\Builders\NameInputBuilder;;
use Werp\Builders\AmountInput;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Base\Builders\SimpleBaseForm;

class DiscountForm extends SimpleBaseForm
{
    protected $moduleRoute = 'admin.sales.discounts';
    protected $mainTitle = 'Descuentos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function makeInputs()
    {
        return $this
            ->addInput(new NameInputBuilder)
            ->addInput(new DescriptionInputBuilder)
            ->addSelect(new OperationSelect);
    }
}