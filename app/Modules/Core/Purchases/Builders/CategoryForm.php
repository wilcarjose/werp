<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Purchases\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveActionBuilder;
use Werp\Builders\UpdateActionBuilder;
use Werp\Builders\SupplierCategorySelectBuilder;


class CategoryForm extends FormBuilder
{
    protected $moduleRoute = 'admin.purchases.categories';
    protected $listRoute = 'admin.purchases.categories.index';

    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Categorias de proveedores')
            ->setRoute($this->moduleRoute)
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage()
    {
        $this
            ->newConfig('Nueva categoria')
            ->addInput(new NameInputBuilder)
            ->addSelect((new SupplierCategorySelectBuilder)->setText('Categoria padre')->addNone())
            ->addAction(new SaveActionBuilder)
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this->data = $data;

        $this
            ->editConfig('Editar categoria')
            ->addInput(new NameInputBuilder)
            ->addSelect((new SupplierCategorySelectBuilder)->setText('Categoria padre')->addNone())
            ->addAction(new UpdateActionBuilder)
            ->setData($data)
        ;

        return $this->view();
    }
}