<?php

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Products\Models\Brand;

class BrandSelect extends SelectBuilder
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
        $this->name  = $name ?: 'brand_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.products.brand');
        $this->value = $value;
        $this->data  = Brand::select('id', 'name')
            ->active()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}