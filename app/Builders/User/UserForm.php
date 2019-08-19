<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Builders\User;

use Werp\Builders\FormBuilder;
use Werp\Builders\InputBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\BreadcrumbBuilder;


class UserForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), 'Home');
        //$this->setTitle('Usuarios')
        //    ->setRoute('admin.user')
        //    ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [])
    {
        if ($action == 'edit') {
            return $this->editUserPage($data);
        }

        return $this->createUserPage();
    }

    public function createUserPage()
    {
        $this->setAction('Nuevo usuario')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person'))
            ->addInput(new InputBuilder('email', 'email', 'Email', 'email'))
            ->addInput(new InputBuilder('pic', 'image'))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Guardar', 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.user.index')))
        ;

        return $this->view();
    }

    public function editUserPage($data)
    {
        $this->data = $data;

        $this->setAction('Editar usuario')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('name', 'input', 'Name', 'person', $data['name']))
            ->addInput(new InputBuilder('email', 'email', 'Email', 'email', $data['email']))
            ->addInput(new InputBuilder('pic', 'image', $data['pic']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, 'Actualizar', 'save', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, 'Cancelar', '', 'button', route('admin.user.index')))
        ;

        return $this->view();
    }
}