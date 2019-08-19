<?php

namespace Werp\Builders\Selects;

use Werp\Builders\Modals\NewSupplierModal;
use Werp\Modules\Core\Purchases\Models\Partner;

class SupplierSelectBuilder extends PartnerSelectBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($value = null, $name = null, $text = null, $none = false, $disable = false, $advancedOption = false,  $icon = null)
    {

        $partners = Partner::where('is_supplier', 'y')->active()->get();

        $this->name  = $name ?: 'partner_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.supplier');
        $this->value = $value;
        $this->data  = $partners;
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
        $this->labelKey = 'doc_and_name';
        $this->allowNew = true;
        $this->modal = new NewSupplierModal;
    }
}