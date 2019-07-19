<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders;

use Werp\Modules\Core\Products\Models\Config;
use Werp\Modules\Core\Products\Models\Warehouse;

class WarehouseSelectBuilder extends SelectBuilder
{


    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($value = null, $name = null, $text = null, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name ?: 'warehouse_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.warehouse');
        $this->value = $value ?: Config::where('key', 'inv_default_warehouse')->first()->value;
        $this->data  = Warehouse::where('status', 'active')->get();
        $this->disable  = $disable;
        $this->none = false;
        $this->advancedOption = $advancedOption;
    }
}