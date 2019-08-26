<?php

namespace Werp\Builders\Actions;

class NextAction extends ActionBuilder
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
        $this->name = 'save';
        $this->type = 'url';
        $this->event = 'button';
        $this->text = trans('view.next');
        $this->icon = 'play_circle_filled';
        $this->iconPosition = 'right';
        $this->route = null;
    }

}