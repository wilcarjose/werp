<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Products\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\DateInput;
use Werp\Builders\Actions\PrintAction;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Inputs\TextInput;
use Werp\Builders\Inputs\CodeInput;
use Werp\Builders\Actions\SaveAction;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\CurrencySelect;
use Werp\Builders\Selects\CustomerSelectBuilder;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class ProductOutputForm extends SimplePage
{
    protected $moduleRoute = 'admin.products.product_output';
    protected $mainTitle = 'Entrega de productos';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs($new = false)
    {
        if (!$new) {
            //$inputs[] = new CodeInput;
        }

        $inputs[] = new DateInput;
        $inputs[] = new CustomerSelectBuilder;
        $inputs[] = new WarehouseSelect;
        $inputs[] = new CurrencySelect;
        $inputs[] = (new DescriptionInput)->advancedOption();
        $inputs[] = (new TextInput('order_code', 'Código de orden'))->advancedOption()->disabled();
        $inputs[] = (new DoctypeSelect(Basedoc::IO_DOC, Config::INV_DEFAULT_IO_DOC))->advancedOption();

        return $inputs;
    }

    public function createPage()
    {
        return $this;
        
        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->newTitle)
            ->setInputs($this->getInputs(true))
            ->addAction(new ContinueAction)
            ->setAdvancedOptions()
            ->goBackEdit()
        ;

        return $this
            ->setShortAction($this->newTitle)
            ->newConfig()
            ->addForm($form)->view()
        ;
    }

    public function editPage($data)
    {
        $disable = $data['state'] != Basedoc::PE_STATE;
        $noProcessed = $data['state'] == Basedoc::PE_STATE;

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction('Entrega # ' . $data['code'])
            ->setInputs($this->getInputs())
            ->setData($data)
            ->setAdvancedOptions()
            ->setWidth('s10 push-m1')
            ->setEdit();
        ;

        if ($noProcessed) {
            $form->addAction(new UpdateAction);
        }

        $form
            ->setState(trans(config('products.document.actions.'.Basedoc::IO_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('products.document.actions.'.Basedoc::IO_DOC.'.'.$data['state'].'.color'))
            ->setPrintAction((new PrintAction)->setRoute(route($this->getRoute().'.print', $data['id'])))
        ;

        $actionKeys = config('products.document.actions.'.Basedoc::IO_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('products.document.actions.'.Basedoc::IO_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.products.product_output.'.$action['key'], $data['id'])));
        }

        return $this
            ->addList(new ProductOutputLinesList(false, $data['id'], $disable))
            ->setListsWidth('s10 push-m1')
            ->setShortAction($this->editTitle)
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}
