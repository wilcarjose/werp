<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */
namespace Werp\Builders\Selects;

use Werp\Modules\Core\Maintenance\Models\PriceListType;

/**
 * Undocumented class
 * 
 * @package Builder
 * @author  Wilcar J. Angulo <wilcarjose@gmail.com>
 */
class SalePriceListSelect extends SelectBuilder
{
    /**
     * InputBuilder constructor.
     * 
     * @param string  $value 
     * @param string  $name 
     * @param string  $text 
     * @param boolean $none 
     * @param boolean $disable 
     * @param boolean $advancedOption 
     * @param string  $icon 
     */
    public function __construct(
        $value = null,
        $name = null,
        $text = null,
        $none = false,
        $disable = false,
        $advancedOption = false,
        $icon = null
    ) {
        $this->name  = $name ?: 'price_list_type_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.products.price_list_type');
        $this->value = $value;
        $this->data  = PriceListType::select('id', 'name')
            ->active()
            ->saleLists()
            ->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }

}