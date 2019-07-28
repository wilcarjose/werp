<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\SaveActionBuilder;
use Werp\Builders\AmountInputBuilder;
use Werp\Builders\UpdateActionBuilder;
use Werp\Builders\DescriptionInputBuilder;
use Werp\Modules\Core\Maintenance\Models\Config;

class AmountOperationForm extends FormBuilder
{
    protected $moduleRoute = 'admin.maintenance.amount_operations';

    public function __construct()
    {
        $this->init('Operaciones de montos');
    }

    public function createPage()
    {
        $this
            ->newConfig('Nueva operación')
            ->makeInputs()
            ->addAction(new SaveActionBuilder)
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this
            ->editConfig('Editar operación')
            ->makeInputs()
            ->addAction(new UpdateActionBuilder)
            ->setData($data)
        ;

        return $this->view();
    }

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