<?php

namespace Werp\Modules\JMJ\ML\Builders;

use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\SelectBuilder;

class ConfigForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Mercado Libre')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('admin.ml.config.edit', 'Configurar'));
    }

    public function configPage($id, $key, $country)
    {
        $this
            ->setMessagesWidth('m8 push-m2')
            ->addForm($this->getConfigForm($id, $key, $country))
            ;

        return $this->view();
    }

    protected function getConfigForm($id, $key, $country)
    {
        $form = new FormBuilder;

        $form->setAction('Claves de acceso')
            ->setEdit()
            ->setRoute('admin.ml.config')
            ->setMiddleWidth()
            ->addAction(new UpdateAction())
        ;

        $countries = config('ml.countries');
        $form->addInput(new InputBuilder('ml_id', 'Id de aplicación', $id))
            ->addInput(new InputBuilder('ml_key', 'Clave secreta', $key))
            ->addSelect((new SelectBuilder('ml_country', 'País', $countries, $country)));

        return $form;
    }
}
