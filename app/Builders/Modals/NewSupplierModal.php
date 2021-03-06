<?php

namespace Werp\Builders\Modals;

use Werp\Builders\Inputs\InputBuilder;

class NewSupplierModal extends NewModal
{
    /**
     * NewModal constructor.
     * @param $endpoint
     * @param $title
     * @param $icon
     */
    public function __construct()
    {
        $this->endpoint = '/admin/purchases/suppliers';
        $this->title = 'Nuevo proveedor';
        $this->label = 'doc_and_name';
        $this->addInput(new InputBuilder('document', 'Documento'))
            ->addInput(new InputBuilder('name', 'Nombre'))
            ->addInput(new InputBuilder('address', 'Dirección'))
            ->addInput(new InputBuilder('mobile', 'Teléfono'));
    }
}