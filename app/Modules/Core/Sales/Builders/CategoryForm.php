<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\NameInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveAction;
use Werp\Builders\UpdateAction;
use Werp\Builders\CustomerCategorySelectBuilder;


class CategoryForm extends FormBuilder
{
    protected $moduleRoute = 'admin.sales.categories';
    protected $listRoute = 'admin.sales.categories.index';

    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'), trans('view.dashboard'));
        $this->setTitle('Categorias de clientes')
            ->setRoute($this->moduleRoute)
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage()
    {
        $this
            ->newConfig('Nueva categoria')
            ->addInput(new NameInputBuilder)
            ->addSelect((new CustomerCategorySelectBuilder)->setText('Categoria padre')->addNone())
            ->addAction(new SaveAction)
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this->data = $data;

        $this
            ->editConfig('Editar categoria')
            ->addInput(new NameInputBuilder)
            ->addSelect((new CustomerCategorySelectBuilder($data['id']))->setText('Categoria padre')->addNone())
            ->addAction(new UpdateAction)
            ->setData($data)
        ;

        return $this->view();
    }
}