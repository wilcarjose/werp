<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Checks\CheckBuilder;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Modules\Core\Base\Builders\SimplePage;

class ExchangeRateForm extends SimplePage
{
    protected $moduleRoute = 'admin.maintenance.exchange_rates';
    protected $mainTitle = 'Tasas de cambio';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Actualizar valor';

    protected function getInputs()
    {
        return [
            //new NameInput,
            (new CurrencySelect)->setName('currency_from_id')->setText('Moneda'),
            (new CurrencySelect)->setName('currency_to_id')->setText('Valor en'),
            (new AmountInput('value', 'Valor')),
            (new CheckBuilder('generate_price_list', 'Actualizar lista de precios?')),
        ];
    }
}