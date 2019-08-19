<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Selects\CurrencySelectBuilder;

class ConfigForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Configuración General')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('admin.maintenance.config.edit', 'Configurar'));
    }

    public function configPage($data)
    {
        $this
            ->addForm($this->getDefaultDocsForm($data['docs']))
            ->addForm($this->getConfigValuesForm($data['inputs'], $data['currencies']))
            ->addForm($this->getProductForm($data['products']))
            
            
            ;

        return $this->view();
    }

    protected function getDefaultDocsForm($docs)
    {
        $form = new FormBuilder;

        $form->setAction('Documentos por defecto')
            ->setEdit()
            ->setRoute('admin.maintenance.config')
            ->setMiddleWidth()
            ->addAction(new UpdateAction())
        ;

        foreach ($docs as $doc) {

            $form->addSelect((
                new DoctypeSelect($doc['doc'], $doc['key']))
                    ->setText(trans($doc['translate_key']))
                    ->setName($doc['key']));
        }

        return $form;
    }

    protected function getProductForm($products)
    {
        $form = new FormBuilder;

        $form->setAction('Productos')
            ->setEdit()
            ->setRoute('admin.maintenance.config')
            ->setMiddleWidth()
            ->addAction(new UpdateAction())
        ;

        foreach ($products as $config) {
            if ($config['select'] == 'warehouse') {
                $form->addSelect((new WarehouseSelect($config['key'], trans($config['translate_key']))));
            }
        }

        return $form;
    }

    protected function getConfigValuesForm($configs, $currencies)
    {
        $form = new FormBuilder;

        $form->setAction('Monedas')
            ->setEdit()
            ->setRoute('admin.maintenance.config')
            ->setMiddleWidth()
            ->addAction(new UpdateAction())
        ;

        foreach ($configs as $config) {
            $form->addInput((new AmountInput($config['key'], trans($config['translate_key']), $config['value'])));
        }

        foreach ($currencies as $currency) {
            $form->addSelect((new CurrencySelectBuilder())
                ->setName($currency['key'])
                ->setText(trans($currency['translate_key']))
                ->setValue($currency['value'])
            );
        }

        return $form;
    }

    public function getCreateRoute()
    {
        return null;
    }
}