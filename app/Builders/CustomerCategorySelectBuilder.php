<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 08/06/19
 * Time: 10:43 AM
 */

namespace Werp\Builders;

class CustomerCategorySelectBuilder extends CategorySelectBuilder
{
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

        parent::__construct('customer', $value, $name ?: 'category_id', $text ?: trans('view.category'), $none, $disable, $advancedOption, $icon);
    }
}