<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Inputs\NameInputBuilder;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Inputs\DescriptionInputBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Base\Builders\SimplePage;

class AmountOperationForm extends SimplePage
{
    protected $moduleRoute = 'admin.maintenance.amount_operations';
    protected $mainTitle = 'Operaciones de montos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        $values = Config::where('type', 'amount')->get();

        return [
            (new NameInputBuilder),
            (new DescriptionInputBuilder),
            (new SelectBuilder('operation', 'Operación', config('werp.operations'), 'multiply', true)),
            ((new SelectBuilder('config_key', 'Valor', $values, '', true))->setIdKey('key')->setLabelKey('name')),
            (new AmountInput('value', 'O usar valor manual')),
            (new SelectBuilder('round', 'Redondeo', config('werp.rounds'), '2', true)),
        ];
    }
}