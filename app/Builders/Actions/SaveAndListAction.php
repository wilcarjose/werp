<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 18/02/19
 * Time: 06:37 PM
 */

namespace Werp\Builders\Actions;


class SaveAndListAction extends ActionBuilder
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
        $this->text = trans('view.save_and_list');
        $this->icon = null;
        $this->route = null;
        $this->value = 'list';
    }

}