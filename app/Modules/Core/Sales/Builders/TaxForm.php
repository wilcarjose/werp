<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\OperationSelect;
use Werp\Builders\NameInputBuilder;;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Base\Builders\SimpleBaseForm;

class TaxForm extends SimpleBaseForm
{
    protected $moduleRoute = 'admin.sales.taxs';
    protected $mainTitle = 'Impuestos';
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