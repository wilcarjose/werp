<?php

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\Inputs\TextInput;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\EmailInput;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Builders\Selects\SupplierCategorySelect;


class SupplierForm extends SimplePage
{
    protected $moduleRoute = 'admin.purchases.suppliers';
    protected $mainTitle = 'Proveedores';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new TextInput('document', trans('view.document')),
            new NameInput,
            new DescriptionInput,
            new SupplierCategorySelect,
            new TextInput('contact_person', trans('view.contact_person')),
            new TextInput('economic_activity', trans('view.economic_activity')),
            new TextInput('mobile', trans('view.mobile')),
            new TextInput('phone', trans('view.phone')),
            new EmailInput,
            new TextInput('web', trans('view.web')),
        ];
    }
}