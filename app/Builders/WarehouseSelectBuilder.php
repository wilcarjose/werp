<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders;

use Werp\Modules\Core\Maintenance\Models\Config;
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
    public function __construct($name = null, $text = null, $value = null, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = $name ?: 'warehouse_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.warehouse');
        $this->value = $value ?: Config::where('key', 'inv_default_warehouse')->firstOrFail()->value;
        $this->data  = Warehouse::active()->get();
        $this->disable  = $disable;
        $this->none = false;
        $this->advancedOption = $advancedOption;
    }
}