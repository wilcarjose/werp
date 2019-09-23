<?php

namespace Werp\Builders\Files;

class SqlFile extends FileBuilder
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
        $this->text = 'SQL';
        $this->value = null;
        $this->disable = false;
        $this->placeholder = 'Seleccione un archivo .sql';
    }
}