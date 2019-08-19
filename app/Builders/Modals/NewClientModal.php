<?php

namespace Werp\Builders\Modals;

use Werp\Builders\Inputs\InputBuilder;

class NewClientModal extends NewModal
{
    /**
     * NewModal constructor.
     * @param $endpoint
     * @param $title
     * @param $icon
     */
    public function __construct()
    {
        $this->endpoint = '/admin/sales/customers';
        $this->title = 'Nuevo cliente';

        $this->addInput(new InputBuilder('document', 'input', 'Documento'))
            ->addInput(new InputBuilder('name', 'input', 'Nombre'))
            ->addInput(new InputBuilder('address', 'input', 'Dirección'))
            ->addInput(new InputBuilder('mobile', 'input', 'Teléfono'));
    }
}