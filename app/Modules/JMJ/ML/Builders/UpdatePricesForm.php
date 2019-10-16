<?php

namespace Werp\Modules\JMJ\ML\Builders;

use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Inputs\HiddenInput;
use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Tables\Cell;
use Werp\Builders\Tables\TableBuilder;
use Werp\Builders\Selects\PriceListTypeSelect;

class UpdatePricesForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Mercado Libre')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('admin.ml.update-prices.edit', 'Actualizar precios'));
    }

    public function editPage($data)
    {
        $this->setMessagesWidth('m8 push-m2')
            ->addForm($this->generateForm($data));

        if (!empty($data['products'])) {
            $this->addForm($this->pricesForm($data['price_list_type_id'], $data['products']));
        }

        return $this->view();
    }

    protected function generateForm($data)
    {
        $form = new FormBuilder;

        $form->setAction('Actualizar precios')
            ->setEdit()
            ->setRoute('admin.ml.update-prices')
            //->setMiddleWidth()
            ->addSelect((new PriceListTypeSelect)->setText('Generar desde')->setValue($data['price_list_type_id']))
            //->setData($data)
            ->addAction(new ActionBuilder('view', ActionBuilder::TYPE_BUTTON, 'Ver precios', 'pageview'))

        ;

        return $form;
    }

    protected function pricesForm($priceListTypeId, $products)
    {
        $form = new FormBuilder;

        for ($i=0; $i<count($products); $i++) {
            $products[$i][3] = (new Cell())->setInputData($products[$i][1], $products[$i][1], $products[$i][3]);
        }

        $table = (new TableBuilder)->setWidth('s12');
        $table->setArrayHeader(['Código', 'Código ML',  'Nombre', 'Precio'])
            ->setArrayRows($products);
        $form->addTable($table)
            ->setAction('Actualizar precios')
            ->setEdit()
            ->addInput(new HiddenInput('price_list_type_id', $priceListTypeId))
            ->setRoute('admin.ml.update-prices')
            ->setMainRoute('send')
            ->addAction((new ActionBuilder('export', ActionBuilder::TYPE_LINK, 'Descargar en Excel', 'cloud_download', 'button', route('admin.ml.update-prices.export', $priceListTypeId)))->setConfirm(false))
            ->addAction(new ActionBuilder('send', ActionBuilder::TYPE_BUTTON, 'Enviar a Mercado Libre', 'cloud_upload'))
        ;

        return $form;
    }
}
