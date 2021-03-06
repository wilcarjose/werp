<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class DoctypeSelect extends SelectBuilder
{


    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($base, $defauly_key = '', $value = null, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = 'doctype_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = trans('view.document');
        $this->value = $value ?: (Config::where('key', $defauly_key)->first()->value ?? null);
        $this->data  = Basedoc::where('type', $base)->first()->doctypes()->get();
        $this->disable  = $disable;
        $this->none = false;
        $this->advancedOption = false;
    }
}
