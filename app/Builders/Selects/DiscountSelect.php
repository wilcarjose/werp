<?php

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Sales\Models\TaxDiscount;

class DiscountSelect extends SelectBuilder
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
        $this->name  = $name ?: 'discount_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.discount');
        $this->value = $value;
        $this->data  = TaxDiscount::select('id', 'name')
            ->sales()
            ->discounts()
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}