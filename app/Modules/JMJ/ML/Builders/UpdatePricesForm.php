<?php

namespace Werp\Modules\JMJ\ML\Builders;

use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Tables\TableBuilder;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\PriceListTypeSelect;

class UpdatePricesForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Mercado libre')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('admin.ml.update-prices.edit', 'Mercado libre'));
    }

    public function editPage($data)
    {
        $this->addForm($this->getConfigValuesForm($data));

        return $this->view();
    }

    protected function getConfigValuesForm($data)
    {
        $table = (new TableBuilder)->setWidth('s12');
        $table->setArrayHeader(['Código', 'Nombre', 'Precio'])
            ->setArrayRows([
                ['MLV-54748393', 'Producto nro 1', '567987'],
                ['MLV-54748354', 'Producto nro 2', '3453454'],
                ['MLV-54748326', 'Producto nro 3', '457647'],
                ['MLV-54748386', 'Producto nro 4', '4545'],
                ['MLV-54748337', 'Producto nro 1', '5788'],
                ['MLV-54748386', 'Producto nro 1', '454353'],
                ['MLV-54748385', 'Producto nro 1', '7868'],
                ['MLV-54748247', 'Producto nro 1', '13424'],
                ['MLV-54748864', 'Producto nro 1', '678678'],
                ['MLV-54748368', 'Producto nro 1', '23424'],
                ['MLV-54748098', 'Producto nro 1', '78678'],
            ]);
        $form = new FormBuilder;

        $form->setAction('Actualizar precios')
            ->setEdit()
            ->setRoute('admin.ml.update-prices')
            //->setMiddleWidth()
            ->addSelect((new PriceListTypeSelect)->setText('Lista a generar'))
            ->addTable($table)
            //->setData($data)
            ->addAction(new UpdateAction())
        ;

        return $form;
    }
}