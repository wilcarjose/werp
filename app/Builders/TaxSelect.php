<?php

namespace Werp\Builders;

use Werp\Modules\Core\Sales\Models\Tax;
use Werp\Modules\Core\Products\Models\Order;

class TaxSelect extends SelectBuilder
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
        $this->name  = $name ?: 'tax_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.tax');
        $this->value = $value;
        $this->data  = Tax::select('id', 'name')
            ->where('type', Order::SALE_TYPE)
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}