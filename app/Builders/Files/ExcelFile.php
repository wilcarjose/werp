<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 17/02/19
 * Time: 01:59 PM
 */

namespace Werp\Builders\Files;


class ExcelFile extends FileBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct()
    {
        $this->name = 'file';
        $this->type = 'file';
        $this->icon = null;
        $this->text = 'Excel';
        $this->value = null;
        $this->disable = false;
        $this->placeholder = 'Seleccione un archivo de excel';
    }
}