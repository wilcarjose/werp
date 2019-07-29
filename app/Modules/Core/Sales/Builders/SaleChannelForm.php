<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\OperationSelect;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Base\Builders\SimpleBaseForm;

class SaleChannelForm extends SimpleBaseForm
{
    protected $moduleRoute = 'admin.sales.sales_channels';
    protected $mainTitle = 'Canales de ventas';
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