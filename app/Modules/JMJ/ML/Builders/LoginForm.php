<?php

namespace Werp\Modules\JMJ\ML\Builders;

use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\PageBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\Files\SqlFile;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\Actions\UpdateAction;

class LoginForm extends PageBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Mercado libre')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder('admin.ml.login.view', 'Login'));
    }

    public function page($isLogged = true)
    {
        $isLogged ?
            $this->addForm($this->logoutForm()) :
            $this->addForm($this->loginForm());

        return $this->view();
    }

    protected function loginForm()
    {
        $form = new FormBuilder;

        $form->setAction('Haz click en el botón Login para conectarte a Mercado Libre')
            ->setEdit()
            ->setRoute('admin.ml.login')
            ->setMainRoute('post')
            ->setInputs([])
            ->addAction(new ActionBuilder('view', ActionBuilder::TYPE_BUTTON, 'Login', 'vpn_key'))
        ;

        return $form;
    }

    protected function logoutForm()
    {
        $form = new FormBuilder;

        $form->setAction('Estas logueado en Mercado Libre como: ' . session('ml_nickname') . '. Para cerrar la sesión haz click en el botón Logout.' )
            ->setEdit()
            ->setRoute('admin.ml.logout')
            ->setMainRoute('do')
            ->setInputs([])
            ->addAction(new ActionBuilder('view', ActionBuilder::TYPE_BUTTON, 'Logout', 'vpn_key'))
        ;

        return $form;
    }
}
