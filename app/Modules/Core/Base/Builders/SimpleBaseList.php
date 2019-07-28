<?php

namespace Werp\Modules\Core\Base\Builders;

use Werp\Builders\Main\MainList;

abstract class SimpleBaseList extends MainList
{
    protected $title;
    protected $route;
    protected $fields;

    public function __construct()
    {
        $this->setTitle($this->title)
            ->setRoute($this->route)
            ->setShowStatus(true)
            ->setFields($this->fields)
            ->makeConfig();

        parent::__construct();
    }
}