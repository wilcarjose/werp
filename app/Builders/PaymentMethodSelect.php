<?php

namespace Werp\Builders;

use Werp\Modules\Core\Sales\Models\PaymentMethod;

class PaymentMethodSelect extends SelectBuilder
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
        $this->name  = $name ?: 'payment_method_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.payment_method');
        $this->value = $value;
        $this->data  = PaymentMethod::select('id', 'name')
            ->sales()
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}