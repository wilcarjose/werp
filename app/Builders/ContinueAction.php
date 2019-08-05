<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 18/02/19
 * Time: 06:37 PM
 */

namespace Werp\Builders;


class ContinueAction extends ActionBuilder
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
        $this->type = ActionBuilder::TYPE_BUTTON;
        $this->event = 'submit';
        $this->text = trans('view.continue');
        $this->icon = 'add';
        $this->route = null;
    }

}