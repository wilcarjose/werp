<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\TabBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Inputs\HiddenInput;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Inputs\AddressInput;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Actions\NextAction;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Actions\SaveAndNewAction;
use Werp\Builders\Actions\SaveAndEditAction;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Builders\Selects\SupplierCategorySelect;

class InitialConfigForm extends SimplePage
{
    protected $moduleRoute = 'admin.maintenance.general_config';
    protected $mainTitle = 'Configuración necesaria';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    public function editPage($data)
    {
        $this->addTab((new TabBuilder('company', trans('view.menu.company'), true, 'looks_one')));
        $this->addTab((new TabBuilder('currency', trans('view.menu.currencies'), false, 'looks_two')));
        $this->addTab((new TabBuilder('warehouse', trans('view.menu.warehouses'), false, 'looks_3'))->setColor('#cd0a0a'));
        $this->addTab((new TabBuilder('end', 'Fin', false, 'looks_4', true)));

        $form = (new FormBuilder)
            ->setAction('Empresa')
            ->setEdit()
            ->setRoute('admin.maintenance.general_config')
            ->setMainRoute('company')
            ->addInput(new InputBuilder('document', 'Rif'))
            ->addInput(new NameInput)
            ->addInput(new AddressInput)
            ->addInput(new InputBuilder('phone1', 'Teléfono'))
            ->setData($data['company'])
            ->addAction(new UpdateAction())
            ->addAction(new NextAction())
            ->setId('company');
        ;

        $currencyForm = $this->getConfigValuesForm($data['currencies']);
        $warehouseForm = $this->getWarehouseForm($data['warehouse']);

        return $this
            ->editConfig()
            ->setBreadcrumbs(null)
            ->addForm($form)
            ->addForm($currencyForm)
            ->addForm($warehouseForm)
            ->view()
        ;
    }

    protected function getConfigValuesForm($currencies)
    {
        $form = new FormBuilder;

        $form->setAction('Monedas')
            ->setEdit()
            ->setRoute('admin.maintenance.general_config')
            ->setMainRoute('currency')
            ->addAction(new UpdateAction())
            ->addAction(new NextAction())
            ->setId('currency');
        ;

        foreach ($currencies as $currency) {
            $form->addSelect((new CurrencySelect())
                ->setName($currency['key'])
                ->setText(trans($currency['translate_key']))
                ->setValue($currency['value'])
            );
        }

        return $form;
    }

    protected function getWarehouseForm($warehouse)
    {
        $warehouse['id'] = $warehouse['id'] ?? '';

        return (new FormBuilder)
            ->setRoute('admin.maintenance.general_config')
            ->setMainRoute('warehouse')
            ->setAction('Almacén')
            ->addInput(new NameInput)
            ->addInput(new HiddenInput('id', $warehouse['id']))
            ->addAction(new UpdateAction)
            ->addAction(new NextAction)
            ->setData($warehouse)
            ->setId('warehouse')
            ->setEdit();
        ;
    }
}