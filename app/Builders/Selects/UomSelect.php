<?php

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Products\Models\Uom;

class UomSelect extends SelectBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $value = null, $none = true, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name ?: 'uom_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: 'Unidad de medida';
        $this->value = $value;
        $this->data  = Uom::select('id', 'name')
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}