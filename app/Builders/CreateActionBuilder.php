<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 18/02/19
 * Time: 06:37 PM
 */

namespace Werp\Builders;


class CreateActionBuilder extends ActionBuilder
{
    public function __construct()
    {
        $this->name = 'save';
        $this->type = self::TYPE_BUTTON;
        $this->event = 'submit';
        $this->text = trans('view.save');
        $this->icon = 'add';
        $this->route = null;
    }
}