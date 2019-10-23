<?php

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\Checks\CheckBuilder;
use Werp\Builders\InputGroupBuilder;
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
use Werp\Modules\Core\Maintenance\Models\PriceList as PriceListModel;

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

    public function editPage($data, $defaulTab = null)
    {
        $this->addTab((new TabBuilder('basic', trans('view.general'), $defaulTab == 'basic')));
        $this->addTab((new TabBuilder('stock', 'Stock', $defaulTab == 'stock')));
        $this->addTab((new TabBuilder('ml', trans('view.menu.mercado_libre'), $defaulTab == 'ml')));

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setDefaultTab('basic')
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
        $limits = $data['limits'];
        $allWarehouse = $limits->shift();
        $col1->addCard((new CardBuilder(view('admin.core.products.products.min-max-stock')))->setData([
            'limits' => $limits,
            'all_warehouse' => $allWarehouse,
            'product_id' => $data['product']['id']
        ]));
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

        $row3 = $this->getMLRow($data['product']);
        $row3->addCol($col2);
        $row3->addCol($col3);

        return $this
            ->setTitle('Producto: ' . $data['product']['name'])
            ->setShortAction($data['product']['name'])
            ->editConfig()
            //->addForm($form)
            ->addRow($row1)
            ->addRow($row2)
            ->addRow($row3)
            //->setFormsWidth('m8 s12')
            ->view()
        ;
    }

    public function importPage()
    {
        $inputs = [
            (new ExcelFile)->setWidth('l12'),
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

    public function getMLRow($data)
    {
        $isEnable = $data['ml_enabled'] == 'on';

        $inputs = [
            (new CheckBuilder('ml_enabled', '¿Activar ítem para Mercado Libre?'))->setChecked($isEnable),
            new InputBuilder('ml_item_id', trans('view.code'), $data['ml_item_id'], 'input')
        ];

        $form = (new FormBuilder)
            ->setRoute('admin.ml.item')
            ->setMainRoute('update', ['id' => $data['id']])
            ->setAction('Información para mercado libre')
            ->setInputs($inputs)
            ->addAction(new UpdateAction)
            ->setData($data)
            ->setEdit()
            ->setIgnoreWidth(true)
            ->setDefaultTab('ml')
        ;

        $colForm = new ColBuilder('s12 m12 l8');
        $colForm->addForm($form);

        $row = new RowBuilder('ml');
        $row->addCol($colForm);

        return $row;
    }
}
