<?php

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Sales\Models\SaleChannel;

class SaleChannelSelect extends SelectBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($name = null, $text = null, $value = null, $none = false, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name ?: 'sale_channel_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.sale_channel');
        $this->value = $value;
        $this->data  = SaleChannel::select('id', 'name')
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}