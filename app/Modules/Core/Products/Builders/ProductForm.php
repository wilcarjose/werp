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
        $this->setTitle('Productos')
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
        $this
            ->newConfig('Nuevo producto')
            ->addInput(new InputBuilder('code', 'input',  trans('view.code')))
            ->addInput(new InputBuilder('name', 'input',  trans('view.name')))
            ->addInput(new InputBuilder('description', 'textarea',  trans('view.description')))
            ->addInput(new InputBuilder('part_number', 'input',  trans('view.products.part_number')))
            ->addSelect(new SelectBuilder('uom_id', 'Unidad de medida', $dependencies['uom']))
            ->addSelect(new SelectBuilder('brand_id', trans('view.products.brand'), $dependencies['brands']))
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), $dependencies['categories']))
            ->addSelect((new SelectBuilder('partner_id', trans('view.products.supplier'), $dependencies['suppliers']))->advancedOption())
            ->addInput((new InputBuilder('barcode', 'input',  trans('view.products.barcode')))->advancedOption())
            ->addInput((new InputBuilder('link', 'input',  trans('view.products.link')))->advancedOption())
            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.save'), 'add', 'submit'))
            
            ->setAdvancedOptions()
        ;

        return $this->view();
    }

    public function editPage($data, $dependencies = [])
    {
        $this->data = $data;

        $this
            ->editConfig('Editar producto')
            ->addInput(new InputBuilder('code', 'input',  trans('view.code'), null, $data['code']))
            ->addInput(new InputBuilder('name', 'input',  trans('view.name'), null, $data['name']))
            ->addInput(new InputBuilder('description', 'textarea',  trans('view.description'), null, $data['description']))
            ->addInput(new InputBuilder('part_number', 'input',  trans('view.products.part_number'), null, $data['part_number']))
            ->addSelect(new SelectBuilder('uom_id', 'Unidad de medida', $dependencies['uom'], $data['uom_id']))
            ->addSelect(new SelectBuilder('brand_id', trans('view.products.brand'), $dependencies['brands'], $data['brand_id']))
            ->addSelect(new SelectBuilder('category_id', trans('view.products.category'), $dependencies['categories'], $data['category_id']))
            ->addSelect((new SelectBuilder('partner_id', trans('view.products.supplier'), $dependencies['suppliers'], $data['partner_id']))->advancedOption())
            ->addInput((new InputBuilder('barcode', 'input',  trans('view.products.barcode'), null, $data['barcode']))->advancedOption())
            ->addInput((new InputBuilder('link', 'input',  trans('view.products.link'), null, $data['link']))->advancedOption())

            ->addAction(new ActionBuilder('save',ActionBuilder::TYPE_BUTTON, trans('view.update'), 'save', 'submit'))
            ->setData($data)

        ;

        return $this->view();
    }
}