<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\CurrencySelectBuilder;
use Werp\Builders\DescriptionInputBuilder;

class PriceForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Listas de precios')
            ->setRoute('admin.products.prices')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage()
    {
        $this->setAction('Nueva lista de precio')
            ->setShortAction('Nueva')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new NameInputBuilder())
            ->addInput(new DescriptionInputBuilder())
            ->addSelect(new CurrencySelectBuilder())
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            ->setMaxWidth()
            //->setAdvancedOptions()
        ;

        return $this->view();
    }

    public function editPage($data, $selects = null)
    {
        $this->data = $data;

        $this->setAction('Editar lista de precio')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new NameInputBuilder($data['name']))
            ->addInput(new DescriptionInputBuilder($data['description']))
            ->addSelect(new CurrencySelectBuilder($data['currency']))
            //->setAdvancedOptions()
            ;

        $this->addAction(new ActionBuilder('save', ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'));

        $this->setList(new PriceDetailList(false, $data['id'], false))
            ->setMaxWidth();

        return $this->view();
    }
}