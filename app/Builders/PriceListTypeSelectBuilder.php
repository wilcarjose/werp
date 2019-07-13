<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders;

use Werp\Modules\Core\Products\Models\PriceListType;

class PriceListTypeSelectBuilder extends SelectBuilder
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
    public function __construct($value = null, $name = null, $text = null, $none = false, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name ?: 'price_list_type_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.products.price_list_type');
        $this->value = $value;
        $this->data  = PriceListType::select('id', 'name')->where('status', 'active')->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}