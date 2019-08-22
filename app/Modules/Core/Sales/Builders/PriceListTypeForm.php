<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;


class PriceListTypeForm extends SimplePage
{
    protected $defaultType = 'sales';

    protected $moduleRoute = 'admin.sales.price_list_types';
    protected $mainTitle = 'Lista de precios';
    protected $newTitle = 'Nueva';
    protected $editTitle = 'Editar';

    protected $types = [
            [ 
                'id' => 'sales',
                'name' => 'Ventas'
            ],
            [ 
                'id' => 'purchases',
                'name' => 'Compras'
            ],
            [ 
                'id' => 'all',
                'name' => 'Compra y Ventas'
            ],
        ];

    protected function getInputs()
    {
        return [
            new NameInput(),
            new DescriptionInput(),
            new SelectBuilder('type', 'Tipo', $this->types, $this->defaultType),
            new CurrencySelect(),
        ];
    }
}