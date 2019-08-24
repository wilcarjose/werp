<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Sales\Models\PriceListType;

class PriceListTypeSelect extends SelectBuilder
{
    protected $listType = 'sales';

    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($listType = 'sales', $value = null, $name = null, $text = null, $none = false, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name ?: 'price_list_type_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.products.price_list_type');
        $this->value = $value;
        $this->data  = PriceListType::select('id', 'name')->where('type', $listType)->active()->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
        $this->listType = $listType;
    }

    public function setListType($listType)
    {
        $this->listType = $listType;
        return $this;
    }

    public function getListType()
    {
        return $this->listType;
    }
}