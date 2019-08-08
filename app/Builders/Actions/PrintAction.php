<?php

namespace Werp\Builders\Actions;

class PrintAction extends ActionBuilder
{

    /**
     * ActionBuilder constructor.
     * @param $name
     * @param $type
     * @param $event
     * @param $text
     * @param $icon
     * @param $route
     */
    public function __construct()
    {
        $this->name = 'print';
        $this->type = 'url'; //self::TYPE_LINK;
        $this->event = 'button';
        $this->text = trans('view.print');
        $this->icon = 'print';
        $this->route = null;
    }

}