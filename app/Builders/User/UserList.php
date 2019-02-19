<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace App\Builders\User;

use App\Builders\ListBuilder;
use App\Builders\BreadcrumbBuilder;

class UserList extends ListBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), 'Home');
        $this->setTitle('Usuarios')
            ->setRoute('admin.user')
            ->addBreadcrumb($homeBreadcrumb)
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->getTitle()));
    }
}