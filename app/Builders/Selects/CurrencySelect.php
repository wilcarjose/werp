<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Currency;

class CurrencySelect extends SelectBuilder
{
    /**
     * InputBuilder constructor.
     * @param $name
     * @param $type
     * @param $icon
     * @param $text
     * @param $value
     */
    public function __construct($value = null, $none = false, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = 'currency_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = trans('view.currency');
        $this->value = $value ?: Config::where('key', Config::MAI_DEFAULT_CURRENCY)->firstOrFail()->value;
        $this->data  = Currency::active()->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
        $this->labelKey = 'name_and_abbr';
        //$this->idKey = 'abbr';
        //$this->isArrayItem = true;
    }

}