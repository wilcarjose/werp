<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 18/02/19
 * Time: 06:37 PM
 */

namespace Werp\Builders\Actions;


class ImportAction extends ActionBuilder
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
        $this->name = 'import';
        $this->type = ActionBuilder::TYPE_BUTTON;
        $this->event = 'submit';
        $this->text = trans('view.import');
        $this->icon = 'cloud_upload';
        $this->route = null;
    }

}