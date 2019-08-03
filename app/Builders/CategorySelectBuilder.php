<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders;

use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Maintenance\Models\Config;

class CategorySelectBuilder extends SelectBuilder
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
        $key = true;

        if ($type == 'all') {
            $key = false;
        }

        $data = $key ?
            Category::where('type', $type)->active()->get() :
            Category::active()->get();

        $this->name  = $name ?: 'category_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = $text ?: trans('view.category');
        $this->value = $value;
        $this->data  = $data;
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
    }
}