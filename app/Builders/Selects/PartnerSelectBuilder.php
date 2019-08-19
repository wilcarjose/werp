<?php

namespace Werp\Builders\Selects;

use Werp\Builders\Modals\NewClientModal;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Purchases\Models\Partner;

class PartnerSelectBuilder extends SelectBuilder
{


    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($type = 'all', $value = null, $name = null, $text = null, $none = false, $disable = false, $advancedOption = false, $icon = null)
    {
        $key = null;

        if ($type == 'customer') {
            $key = 'is_customer';
        }

        if ($type == 'supplier') {
            $key = 'is_supplier';
        }

        $partners = $key ?
            Partner::where($key, 'y')->active()->get() :
            Partner::active()->get();

        $this->name  = $name ?: 'partner_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.partner');
        $this->value = $value;
        $this->data  = $partners;
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
        $this->labelKey = 'doc_and_name';
        $this->allowNew = true;
        $this->modal = new NewClientModal;
    }
}