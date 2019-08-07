<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\SelectBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Base\Builders\SimpleBaseForm;

class AmountOperationForm extends SimpleBaseForm
{
    protected $moduleRoute = 'admin.maintenance.amount_operations';
    protected $mainTitle = 'Operaciones de montos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function makeInputs()
    {
        $values = Config::where('type', 'amount')->get();

        return $this
            ->addInput(new NameInputBuilder)
            ->addInput(new DescriptionInputBuilder)
            ->addSelect(new SelectBuilder('operation', 'Operación', config('werp.operations'), 'multiply', true))
            ->addSelect((new SelectBuilder('config_key', 'Valor', $values, '', true))->setIdKey('key')->setLabelKey('name'))
            ->addInput(new AmountInputBuilder('value', 'O usar valor manual'))
            ->addSelect(new SelectBuilder('round', 'Redondeo', config('werp.rounds'), '2', true));
    }
}