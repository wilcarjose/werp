<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Selects\CurrencySelectBuilder;
use Werp\Modules\Core\Base\Builders\SimplePage;

class ExchangeRateForm extends SimplePage
{
    protected $moduleRoute = 'admin.maintenance.exchange_rates';
    protected $mainTitle = 'Tasas de cambio';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            //new NameInput,
            (new CurrencySelectBuilder)->setName('currency_from_id')->setText('Moneda'),
            (new CurrencySelectBuilder)->setName('currency_to_id')->setText('Valor en'),
            new AmountInput('value', 'Valor'),
        ];
    }
}