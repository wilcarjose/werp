<?php

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\Inputs\AddressInput;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Inputs\TextInput;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\EmailInput;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Selects\CustomerCategorySelectBuilder;
use Werp\Modules\Core\Base\Builders\SimplePage;

class CustomerForm extends SimplePage
{
    protected $moduleRoute = 'admin.sales.customers';
    protected $mainTitle = 'Clientes';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new TextInput('document', trans('view.document')),
            new NameInput(),
            new DescriptionInput,
            new AddressInput,
            new CustomerCategorySelectBuilder,
            new TextInput('contact_person', trans('view.contact_person')),
            new TextInput('economic_activity', trans('view.economic_activity')),
            new TextInput('mobile', trans('view.mobile')),
            new TextInput('phone', trans('view.phone')),
            new EmailInput,
            new TextInput('web', trans('view.web')),
        ];
    }
}