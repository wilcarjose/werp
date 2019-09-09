<?php
/**
 * Created by PhpStorm.
 * User: wilcar
 * Date: 19/02/19
 * Time: 05:40 PM
 */

namespace Werp\Modules\Core\Sales\Builders;

use Werp\Builders\FormBuilder;
use Werp\Builders\Inputs\DateInput;
use Werp\Builders\Checks\CheckBuilder;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\OperationSelect;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\CodeInput;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Selects\ProductCategorySelect;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Selects\PriceListTypeSelect;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;

class PriceListForm extends SimplePage
{
    protected $moduleRoute = 'admin.sales.price_lists';
    protected $mainTitle = 'Listas de precios';
    protected $newTitle = 'Nuevo';
    protected $editTitle = 'Editar';

    protected function getInputs($new = false, $useExchange = false)
    {
        if (!$new) {
            //$inputs[] = new CodeInput;
        }

        $inputs[] = new DateInput('starting_at', trans('view.from'));
        $inputs[] = (new PriceListTypeSelect)->setText('Lista a generar');
        $inputs[] = new PriceListTypeSelect('sales', null, 'reference_price_list_type_id', 'Lista precio base', true);
        $inputs[] = (new CheckBuilder('use_exchange_rate', '¿Usar tasa de cambio?'))->setChecked($useExchange);
        $inputs[] = (new DescriptionInput)->advancedOption();
        $inputs[] = (new OperationSelect)->advancedOption();
        $inputs[] = (new DoctypeSelect(Basedoc::PL_DOC, Config::PRI_DEFAULT_PL_DOC))->advancedOption();
        
        

        return $inputs;
    }

    public function createPage()
    {
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

        $useExchange = isset($data['exchange_rate_id']) && !is_null($data['exchange_rate_id']);

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction('Lista # ' . $data['code'])
            ->setInputs($this->getInputs(false, $useExchange))
            ->setData($data)
            ->setAdvancedOptions()
            ->setWidth('s10 push-m1')
            ->setEdit();
        ;

        if ($noProcessed) {
            $form->addAction(new UpdateAction);
        }

        $form
            ->setList(new PriceList(false, $data['id'], $disable))
            ->setState(trans(config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state'].'.color'))
            //->setMaxWidth()
            ;

        $actionKeys = config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state'].'.new_actions');

        foreach ($actionKeys as $key) {
            $action = config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$key);
            $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.sales.price_lists.'.$action['key'], $data['id'])));
        }

        return $this
            ->setShortAction($this->editTitle)
            ->editConfig()
            ->addForm($form)->view()
        ;
    }
}