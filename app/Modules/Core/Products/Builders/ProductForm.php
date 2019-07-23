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
use Werp\Builders\SelectBuilder;
use Werp\Builders\ActionBuilder;
use Werp\Builders\BreadcrumbBuilder;


class ProductForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'),  trans('view.dashboard'));
        $this->setTitle('Products')
            ->setRoute('admin.products.products')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function showPage($action = 'new', $data = [], $dependencies = [])
    {
        if ($action == 'edit') {
            return $this->editPage($data, $dependencies = []);
        }

        return $this->createPage($dependencies = []);
    }

    public function createPage($dependencies = [])
    {
        $this->setAction('Nuevo producto')
            ->setShortAction('Nuevo')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->addInput(new InputBuilder('code', 'input',  trans('view.code')))
            ->addInput(new InputBuilder('name', 'input',  trans('view.name')))
            ->addInput(new InputBuilder('description', 'textarea',  trans('view.description')))
            ->addInput(new InputBuilder('part_number', 'input',  trans('view.products.part_number')))
            ->addSelect(new SelectBuilder('uom_id', 'Unidad de medida', $dependencies['uom']))
            ->addSelect(new SelectBuilder('partner_id', trans('view.products.supplier'), $dependencies['suppliers']))
            ->addSelect(new SelectBuilder('brand_id', trans('view.products.brand'), $dependencies['brands']))
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), $dependencies['categories']))
            ->addInput(new InputBuilder('barcode', 'input',  trans('view.products.barcode')))
            ->addInput(new InputBuilder('link', 'input',  trans('view.products.link')))
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            ->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.products.index')))
        ;

        return $this->view();
    }

    public function editPage($data, $dependencies = [])
    {
        $this->data = $data;

        $this->setAction('Editar producto')
            ->setShortAction('Editar')
            ->addBreadcrumb(new BreadcrumbBuilder($this->getListRoute(), $this->title))
            ->addBreadcrumb(new BreadcrumbBuilder($this->getActionRoute(), $this->short_action))
            ->setEdit()
            ->addInput(new InputBuilder('code', 'input',  trans('view.code'), null, $data['code']))
            ->addInput(new InputBuilder('name', 'input',  trans('view.name'), null, $data['name']))
            ->addInput(new InputBuilder('description', 'textarea',  trans('view.description'), null, $data['description']))
            ->addInput(new InputBuilder('part_number', 'input',  trans('view.products.part_number'), null, $data['part_number']))
            ->addSelect(new SelectBuilder('uom_id', 'Unidad de medida', $dependencies['uom'], $data['uom_id']))
            ->addSelect(new SelectBuilder('partner_id', trans('view.products.supplier'), $dependencies['suppliers'], $data['partner_id']))
            ->addSelect(new SelectBuilder('brand_id', trans('view.products.brand'), $dependencies['brands'], $data['brand_id']))
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), $dependencies['categories'], $data['category_id']))
            ->addInput(new InputBuilder('barcode', 'input',  trans('view.products.barcode'), null, $data['barcode']))
            ->addInput(new InputBuilder('link', 'input',  trans('view.products.link'), null, $data['link']))

            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'))
            //->addAction(new ActionBuilder('cancel',ActionBuilder::TYPE_LINK, trans('view.cancel'), '', 'button', route('admin.products.products.index')))
        ;

        return $this->view();
    }
}