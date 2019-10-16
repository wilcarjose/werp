<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 18/02/19
 * Time: 06:37 PM
 */

namespace Werp\Builders\Actions;


class UpdateAction extends ActionBuilder
{
    public function __construct($label = null)
    {
        $this->name = 'save';
        $this->type = ActionBuilder::TYPE_BUTTON;
        $this->event = 'submit';
        $this->text = $label ?? trans('view.update');
        $this->icon = 'save';
        $this->route = null;
    }
}
