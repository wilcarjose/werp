<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders\Selects;

use Werp\Modules\Core\Maintenance\Models\Currency;

class CurrencySelectBuilder extends SelectBuilder
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
    public function __construct($value = null, $none = false, $disable = false, $advancedOption = false,  $icon = null)
    {
        $this->name  = 'currency_id';
        $this->type  = 'select';
        $this->icon  = $icon;
        $this->text  = trans('view.currency');
        $this->value = $value;
        $this->data  = Currency::active()->get();
        $this->disable  = $disable;
        $this->none = $none;
        $this->advancedOption = $advancedOption;
        //$this->idKey = 'abbr';
        //$this->isArrayItem = true;
    }

}