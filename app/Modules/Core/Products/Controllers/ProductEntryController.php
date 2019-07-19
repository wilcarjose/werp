<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Products\Models\Inout;
use Werp\Modules\Core\Products\Models\InoutDetail;
use Werp\Modules\Core\Products\Builders\ProductEntryForm;
use Werp\Modules\Core\Products\Builders\ProductEntryList;
use Werp\Modules\Core\Products\Services\ConfigService;
use Werp\Modules\Core\Products\Services\InoutService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Transformers\InoutTransformer;
use Werp\Modules\Core\Products\Transformers\InoutDetailTransformer;

class ProductEntryController extends BaseController
{
    protected $entity;
    protected $entityDetail;
    protected $entityTransformer;
    protected $entityDetailTransformer;
    protected $entityForm;
    protected $entityList;
    protected $configService;
    protected $doctypeService;
    protected $entityService;

    protected $inputs = [
        'description',
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'doctype_id',
        'warehouse_id',
        'partner_id',
        'date',
    ];

    protected $storeRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
        'partner_id'    => 'required',
        'date'  => 'required|date',
    ];

    protected $updateRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
        'partner_id'    => 'required',
        'date'  => 'required|date',
    ];

    protected $storeDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'warehouse_id' => 'required',
        'amount' => 'required|numeric',
    ];

    protected $updateDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'warehouse_id' => 'required',
        'amount' => 'required|numeric',
    ];

    protected $detailInputs = [
        'qty',
        'amount',
        'product_id',
        'warehouse_id'
    ];

    protected $relatedField = 'inout_id';

    public function __construct(
        Inout $entity,
        InoutDetail $entityDetail,
        InoutService $entityService,
        ProductEntryForm $entityForm,
        ProductEntryList $entityList,
        ConfigService $configService,
        InoutTransformer $entityTransformer,
        TransactionService $transactionService,
        InoutDetailTransformer $entityDetailTransformer        
    ) {
        $this->entity             = $entity;
        $this->entityForm         = $entityForm;
        $this->entityList         = $entityList;
        $this->entityDetail       = $entityDetail;
        $this->configService      = $configService;
        $this->entityService      = $entityService;
        $this->entityTransformer  = $entityTransformer;
        $this->transactionService = $transactionService;
        $this->entityDetailTransformer = $entityDetailTransformer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = $this->entityService->getById($id, false);

        if (!$entity) {
            $entity = $this->entityService->getByCode($id);
        }

        if (!$entity) {
            flash(trans($this->getNotFoundKey()), 'info');
            return back();
        }

        return $this->entityForm->editPage($entity->toArray());
    }

    public function process($id)
    {
        try {

            $this->entityService->process($id);

            flash('Entrada procesada exitosamente', 'success', 'success');
            return redirect(route('admin.products.product_entry.edit', $id));
        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return redirect(route('admin.products.product_entry.edit', $id));
        } catch (NotDetailException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.product_entry.edit', $id));
        } catch (CanNotProcessException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.product_entry.edit', $id));
        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return redirect(route('admin.products.product_entry.edit', $id));
        }
    }

    public function reverse($id)
    {
        try {

            $this->entityService->reverse($id);

            flash('Entrada reversada exitosamente', 'success', 'success');
            return redirect(route('admin.products.product_entry.edit', $id));
        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return redirect(route('admin.products.product_entry.edit', $id));
        } catch (CanNotReverseException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.product_entry.edit', $id));
        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return redirect(route('admin.products.product_entry.edit', $id));
        }
    }
}
