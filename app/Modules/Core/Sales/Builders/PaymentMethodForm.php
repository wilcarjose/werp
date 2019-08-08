<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\OperationSelect;
use Werp\Builders\NameInputBuilder;;
use Werp\Builders\AmountInput;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Base\Builders\SimpleBaseForm;

class PaymentMethodForm extends SimpleBaseForm
{
    protected $moduleRoute = 'admin.sales.payment_methods';
    protected $mainTitle = 'Métodos de pagos';
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