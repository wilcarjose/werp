<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 06:33 PM
 */

namespace Werp\Builders\User;

use Werp\Builders\Main\MainList;

class UserList extends MainList
{
    public function __construct()
    {
        $this->setTitle('Usuarios')
            ->setRoute('admin.user')
            ->setShowStatus(true)
            ->setFields(['fullname' => 'Nombre', 'email' => 'Email'])
            ->makeConfig();

        parent::__construct();
    }
}