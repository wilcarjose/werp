<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\InputBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\BreadcrumbBuilder;


class ConfigForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Configuración')
            ->setRoute('admin.products.config')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function editConfigPage($data, $selects)
    {
        $this->data = $data;

        $this->setAction('Configuración de módulo')
            ->setShortAction('Actualizar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit();

            if (isset($data['selects'])) {
                foreach ($data['selects'] as $select) {
                    $this->addSelect(new SelectBuilder($select['key'], trans($select['translate_key']), $selects[$select['options']], $select['value'], true));
                }
            }
            
            $this->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'))
        ;

        return $this->view();
    }

    public function getCreateRoute()
    {
        return null;
    }
}