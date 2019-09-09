<?php

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Sales\Models\TaxDiscount;

class TaxSelect extends SelectBuilder
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
        $this->name  = $name ?: 'tax_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.tax');
        $this->value = $value;
        $this->data  = TaxDiscount::select('id', 'name')
            ->sales()
            ->taxs()
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}