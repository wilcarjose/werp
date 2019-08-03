<?php

namespace Werp\Builders;

use Werp\Modules\Core\Sales\Models\Discount;
use Werp\Modules\Core\Products\Models\Order;

class DiscountSelect extends SelectBuilder
{
    protected $name;
    protected $type;
    protected $icon;
    protected $text;
    protected $value;
    protected $data;
    protected $disable;
    protected $none;
    protected $advancedOption;


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
        $this->data  = Discount::select('id', 'name')
            ->where('type', Order::SALE_TYPE)
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}