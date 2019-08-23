<?php

namespace Werp\Modules\Core\Maintenance\Builders;

use Werp\Builders\Main\MainList;

class DataBackupList extends MainList
{
    protected $title = 'Respaldo de datos';

    protected $route = 'admin.maintenance.db_backups';

    protected $fields = [
        ['field' => 'name', 'name' => 'Nombre' , 'type' => 'text'],
    ];

    protected $actions = [
        ['icon' => 'cloud_download', 'action' => 'download', 'color' => 'green'],
        ['icon' => 'delete', 'action' => 'destroy', 'color' => '#f44336'],
    ];

    public function __construct()
    {
        $this->setTitle($this->title)
            //->setRoute($this->route)
            ->setShowStatus(false)
            ->setShowEdit(false)
            ->setShowDelete(false)
            ->setFields($this->fields)
            ->setActions($this->actions)
            ->setPaginate(false)
            ->makeConfig();

        parent::__construct();
    }
}