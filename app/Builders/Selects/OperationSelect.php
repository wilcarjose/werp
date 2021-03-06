<?php

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Maintenance\Models\AmountOperation;

class OperationSelect extends SelectBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $value = null, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name ?: 'amount_operation_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.formula');
        $this->value = $value;
        $this->data  = AmountOperation::active()->get();
        $this->disable  = $disable;
        $this->none = true;
        $this->advancedOption = $advancedOption;
    }
}