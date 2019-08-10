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

class ConfigForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Configuración General')
            //->setRoute('admin.maintenance.config')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('admin.maintenance.config.edit', 'Configurar'));
    }

    public function configPage($data)
    {
        $this
            ->addForm($this->getDefaultDocsForm($data['docs']))
            ->addForm($this->getConfigValuesForm($data['inputs']))
            ->addForm($this->getProductForm($data['products']))
            
            
            ;

        return $this->view();
    }

    protected function getDefaultDocsForm($docs)
    {
        $form = new FormBuilder;

        $form->setAction('Documentos por defecto')
            //->setShortAction('Actualizar')
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
            //->setShortAction('Actualizar')
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

     protected function getConfigValuesForm($configs)
    {
        $form = new FormBuilder;

        $form->setAction('Montos')
            //->setShortAction('Actualizar')
            ->setEdit()
            ->setRoute('admin.maintenance.config')
            ->setMiddleWidth()
            ->addAction(new UpdateAction())
        ;

        foreach ($configs as $config) {
            $form->addInput((new AmountInput($config['key'], trans($config['translate_key']), $config['value'])));
        }

        return $form;
    }

    public function getCreateRoute()
    {
        return null;
    }
}