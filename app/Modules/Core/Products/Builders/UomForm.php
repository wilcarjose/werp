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
use Werp\Builders\NameInputBuilder;
use Werp\Builders\BreadcrumbBuilder;
use Werp\Builders\SaveAction;
use Werp\Builders\UpdateAction;
use Werp\Builders\DescriptionInputBuilder;

class UomForm extends FormBuilder
{
    public function __construct()
    {
        $homeBreadcrumb = new BreadcrumbBuilder(route('admin.home'),  trans('view.dashboard'));
        $this->setTitle('Unidad de medidas')
            ->setRoute('admin.products.uom')
            ->addBreadcrumb($homeBreadcrumb);
    }

    public function createPage()
    {
        $this
            ->newConfig('Nueva unidad de medida')            
            ->addInput(new NameInputBuilder)
            ->addInput(new InputBuilder('abbr', 'input', trans('view.abbr')))
            ->addInput(new InputBuilder('symbol', 'input', trans('view.symbol')))
            ->addInput(new DescriptionInputBuilder)
            ->addAction(new SaveAction)
        ;

        return $this->view();
    }

    public function editPage($data)
    {
        $this->data = $data;

        $this
            ->editConfig('Editar unidad de medida')
            ->addInput(new NameInputBuilder)
            ->addInput(new InputBuilder('abbr', 'input', trans('view.abbr')))
            ->addInput(new InputBuilder('symbol', 'input', trans('view.symbol')))
            ->addInput(new DescriptionInputBuilder)
            ->addAction(new UpdateAction)
            ->setData($data)
        ;

        return $this->view();
    }
}