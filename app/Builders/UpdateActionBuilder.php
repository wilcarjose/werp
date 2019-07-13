<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 18/02/19
 * Time: 06:37 PM
 */

namespace Werp\Builders;


class UpdateActionBuilder extends ActionBuilder
{
    public function __construct()
    {
        $this->name = 'save';
        $this->type = self::TYPE_BUTTON;
        $this->event = 'submit';
        $this->text = trans('view.update');
        $this->icon = 'save';
        $this->route = null;
    }
}