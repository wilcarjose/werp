<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\TabBuilder;
use Werp\Builders\ColBuilder;
use Werp\Builders\RowBuilder;
use Werp\Builders\CardBuilder;
use Werp\Builders\FormBuilder;
use Werp\Builders\Files\ExcelFile;
use Werp\Builders\Inputs\NameInput;
use Werp\Builders\Selects\UomSelect;
use Werp\Builders\Actions\SaveAction;
use Werp\Builders\Selects\BrandSelect;
use Werp\Builders\Inputs\InputBuilder;
use Werp\Builders\Actions\ImportAction;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Actions\SaveAndNewAction;
use Werp\Builders\Actions\SaveAndEditAction;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Builders\Selects\ProductCategorySelect;
use Werp\Builders\Selects\SupplierSelectBuilder;

class ProductForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.products';
    protected $mainTitle = 'Productos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs()
    {
        return [
            new InputBuilder('code', trans('view.code')),
            new NameInput,
            new DescriptionInput,
            new UomSelect,
            new BrandSelect,
            new ProductCategorySelect,
            new SupplierSelectBuilder,
            new InputBuilder('part_number', trans('view.products.part_number')),
            new InputBuilder('barcode', trans('view.products.barcode')),
            new InputBuilder('link', trans('view.products.link')),
        ];
    }

    public function createPage()
    {
        $this->addTab((new TabBuilder('basic', trans('view.general'))));
        //$this->addTab((new TabBuilder('stock', trans('view.menu.stock'))));
        //$this->addTab((new TabBuilder('warehouse', trans('view.menu.warehouses'))));
        
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->newTitle)
            ->setInputs($this->getInputs())
            ->addAction(new SaveAndEditAction)
            ->addAction(new SaveAndNewAction)
            ->setId('basic')
        ;

        return $this
            ->setShortAction('Nueva')
            ->newConfig()
            ->addForm($form)->view()
        ;
    }

    public function editPage($data)
    {
        $this->addTab((new TabBuilder('basic', trans('view.general'))));
        //$this->addTab((new TabBuilder('stock', trans('view.menu.stock'))));
        //$this->addTab((new TabBuilder('warehouse', trans('view.menu.warehouses'))));

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction('Información básica')
            ->setInputs($this->getInputs())
            ->addAction(new UpdateAction)
            ->addAction(new SaveAndNewAction)
            ->setData($data['product'])
            ->setEdit()
            ->setIgnoreWidth(true)
        ;

        $colForm = new ColBuilder('s12 m12 l8');
        $colForm->addForm($form);

        $col1 = new ColBuilder('s12 m12 l8');
        $col1->addCard(new CardBuilder(view('admin.core.products.products.min-max-stock')));
        $col2 = new ColBuilder('s12 m12 l4');
        $col2->addCard((new CardBuilder(view('admin.core.products.products.current-stock')))->setData(['stock' => $data['stock']]));
        $col3 = new ColBuilder('s12 m12 l4');
        $col3->addCard((new CardBuilder(view('admin.core.products.products.last-transactions')))->setData(['transactions' => $data['transactions']]));

        $row1 = new RowBuilder('basic');
        $row1->addCol($colForm);
        $row1->addCol($col2);
        $row1->addCol($col3);

        $row2 = new RowBuilder('stock');
        $row2->addCol($col1);
        $row2->addCol($col2);
        $row2->addCol($col3);

        return $this
            ->setShortAction('Editar')
            ->editConfig()
            //->addForm($form)
            ->addRow($row1)
            //->addRow($row2)
            //->setFormsWidth('m8 s12')
            ->view()
        ;
    }

    public function importPage()
    {
        $inputs = [
            new ExcelFile,
        ];

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setMainRoute('import')
            ->setAction($this->newTitle)
            ->setInputs($inputs)
            ->addAction(new ImportAction)
        ;

        return $this
            ->setShortAction('Importar')
            ->newConfig()
            ->addForm($form)->view()
        ;
    }
}