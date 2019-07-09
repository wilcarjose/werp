<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\CurrencySelectBuilder;
use Werp\Builders\DescriptionInputBuilder;


class PriceListTypeForm extends FormBuilder
{
    protected $types = [];
    protected $defaultType = 'sales';

    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'),  trans('view.dashboard'));
        $this->setTitle('Tipos de listas de precios')
            ->setRoute('admin.products.price_list_types')
            ->addBreadcrumb($homeBreadcrumb);

        $this->types = [
            [ 
                'id' => 'sales',
                'name' => 'Ventas'
            ],
            [ 
                'id' => 'purchases',
                'name' => 'Compras'
            ],
            [ 
                'id' => 'all',
                'name' => 'Compra y Ventas'
            ],
        ];
    }

    public function createPage($dependencies = [])
    {
        $this->setAction('Nuevo tipo de lista de precios')
            ->setShortAction('Nueva')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new NameInputBuilder())
            ->addInput(new DescriptionInputBuilder())
            ->addSelect(new SelectBuilder('type', 'Tipo', $this->types, $this->defaultType))
            ->addSelect(new CurrencySelectBuilder())
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
        ;

        return $this->view();
    }

    public function editPage($data, $dependencies = [])
    {
        $this->data = $data;

        $this->setAction('Editar tipo de lista de precios')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new NameInputBuilder($this->data['name']))
            ->addInput(new DescriptionInputBuilder($this->data['description']))
            ->addSelect(new SelectBuilder('type', 'Tipo', $this->types, $this->data['type']))
            ->addSelect(new CurrencySelectBuilder($this->data['currency']))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'))
        ;

        return $this->view();
    }
}