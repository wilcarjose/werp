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
use Werp\Builders\Inputs\CodeInput;
use Werp\Builders\InputGroupBuilder;
use Werp\Builders\Inputs\AmountInput;
use Werp\Builders\Checks\RadioBuilder;
use Werp\Builders\Actions\UpdateAction;
use Werp\Builders\Selects\SelectBuilder;
use Werp\Builders\Actions\ActionBuilder;
use Werp\Builders\Selects\DoctypeSelect;
use Werp\Builders\Actions\ContinueAction;
use Werp\Builders\Selects\OperationSelect;
use Werp\Builders\Selects\WarehouseSelect;
use Werp\Builders\Inputs\DescriptionInput;
use Werp\Builders\Checks\RadioOptionBuilder;
use Werp\Builders\Selects\PriceListTypeSelect;
use Werp\Modules\Core\Base\Builders\SimplePage;
use Werp\Builders\Selects\ProductCategorySelect;
use Werp\Modules\Core\Maintenance\Models\Config;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Sales\Models\PriceList as PriceListModel;

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

        $inputs[] = new DateInput('starting_at', 'Válida a partir de');
        $inputs[] = (new PriceListTypeSelect)->setText('Lista a generar');
        //$inputs[] = new PriceListTypeSelect('sales', null, 'reference_price_list_type_id', 'Lista precio base', true);
        //$inputs[] = (new CheckBuilder('use_exchange_rate', '¿Usar tasa de cambio?'))->setChecked($useExchange);
        //$inputs[] = (new DescriptionInput)->advancedOption();
        //$inputs[] = (new OperationSelect)->advancedOption();
        
        

        return $inputs;
    }

    public function createPage()
    {
        $group = new InputGroupBuilder;
        $group
            ->setTitle('Lista de precios a generar')
            ->setIcon('looks_one')
            ->setInputs($this->getInputs())
            ->setActive(true)
        ;

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction($this->newTitle)
            ->addGroup($group)
            ->addSelect((new DoctypeSelect(Basedoc::PL_DOC, Config::PRI_DEFAULT_PL_DOC))->advancedOption()->setWidth('s5 push-s1'))
            ->addAction(new ContinueAction)
            ->setAdvancedOptions()
            ->setWidth('s12')
            ->goBackEdit()
        ;

        return $this
            //->setWidth('s10 push-m1')
            ->setShortAction($this->newTitle)
            ->newConfig()
            ->addForm($form)->view()
        ;
    }

    public function editListPage($data, $hasDetail)
    {
        $disable = $data['state'] != Basedoc::PE_STATE;
        $noProcessed = $data['state'] == Basedoc::PE_STATE;
        $isManually = old('type') == PriceListModel::MANUALLY || $data['type'] == PriceListModel::MANUALLY;
        $isFormula = old('type') == PriceListModel::FORMULA || $data['type'] == PriceListModel::FORMULA;
        $isExchange = old('type') == PriceListModel::EXCHANGE || $data['type'] == PriceListModel::EXCHANGE;
        $showDetail = $hasDetail ?: $isManually;
        $active = $noProcessed && !$showDetail;

        $inputs1[] = (new DateInput('starting_at', 'Válida a partir de'));
        $inputs1[] = (new PriceListTypeSelect)->setText('Lista a generar');
        //$inputs2[] = (new CheckBuilder('use_exchange_rate', '¿Usar tasa de cambio?'))->setChecked(true);

        $inputs2[] = (new RadioBuilder('type'))
            ->addOption(new RadioOptionBuilder('¿Usando tasa de cambio?', PriceListModel::EXCHANGE, $isExchange, $disable))
            ->addOption(new RadioOptionBuilder('¿Usando fórmula?', PriceListModel::FORMULA, $isFormula, $disable))
            ->addOption(new RadioOptionBuilder('¿Colocar precios manualmente?', PriceListModel::MANUALLY, $isManually, $disable))
            ;

        $inputs2[] = (new PriceListTypeSelect('all', null, 'reference_price_list_type_id', 'Lista precio base', true))
            ->setHide(!$isFormula && !$isExchange)
            ->setShowInputs([PriceListModel::FORMULA, PriceListModel::EXCHANGE])
            ->setHideInputs(PriceListModel::MANUALLY);

        $inputs2[] = (new OperationSelect)
            ->setHide(!$isFormula)
            ->setShowInputs(PriceListModel::FORMULA)
            ->setHideInputs([PriceListModel::MANUALLY, PriceListModel::EXCHANGE]);


        $inputs3[] = (new DescriptionInput)->advancedOption()->setWidth('s11 push-s1');
        //$inputs3[] = (new OperationSelect)->advancedOption()->setWidth('s5 push-s1');
        $inputs3[] = (new DoctypeSelect(Basedoc::PL_DOC, Config::PRI_DEFAULT_PL_DOC))->advancedOption()->setWidth('s5 push-s1');

        $group1 = new InputGroupBuilder;
        $group1
            ->setTitle('Lista de precios a generar')
            ->setIcon('looks_one')
            ->setInputs($inputs1)
        ;

        $group2 = new InputGroupBuilder;
        $group2
            ->setTitle('Calcular precios')
            ->setIcon('looks_two')
            ->setInputs($inputs2)
            ->setActive($active)
        ;

        $form = (new FormBuilder)
            ->setRoute($this->moduleRoute)
            ->setAction('Lista # ' . $data['code'])
            ->addGroup($group1)
            ->addGroup($group2)
            ->setInputs($inputs3)
            ->setData($data)
            ->setAdvancedOptions()
            ->setWidth('s12')
            ->setEdit();
        ;

        if ($noProcessed) {
            $hasDetail ? 
                $form->addAction(new ActionBuilder('generate', ActionBuilder::TYPE_BUTTON, trans('view.generate'))) :
                $form->addAction(new ContinueAction);
        }

        $form
            ->setState(trans(config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state'].'.after_name')))
            ->setStateColor(config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state'].'.color'))
            //->setMaxWidth()
            ;

        $actionKeys = config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$data['state'].'.new_actions');

        if ($hasDetail) {
            foreach ($actionKeys as $key) {
                $action = config('sales.document.actions.'.Basedoc::PL_DOC.'.'.$key);
                $form->addAction(new ActionBuilder($action['key'], ActionBuilder::TYPE_LINK, trans($action['name']), '', 'button', route('admin.sales.price_lists.'.$action['key'], $data['id'])));
            }
        }

        if ($showDetail) {
            $this->addList(new PriceList(false, $data['id'], $disable));
        }

        return $this
            ->setShortAction($this->editTitle)
            ->editConfig()
            ->addForm($form)
            ->view()
        ;
    }
}