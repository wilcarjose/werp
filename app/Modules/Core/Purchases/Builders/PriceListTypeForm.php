<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;


class PriceListTypeForm extends SimplePage
{
    protected $moduleRoute = 'admin.purchases.price_list_types';
    protected $mainTitle = 'Lista de precios de compras';
    protected $newTitle = 'Nueva';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new NameInput(),
            new CurrencySelect(),
            new DescriptionInput(),
        ];
    }
}