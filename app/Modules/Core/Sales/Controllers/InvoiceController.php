<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Sales\Builders\InvoiceForm;
use Werp\Modules\Core\Sales\Builders\InvoiceList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Services\InvoiceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
use Werp\Modules\Core\Sales\Transformers\InvoiceTransformer;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Sales\Transformers\InvoiceLineTransformer;

class InvoiceController extends BaseController
{
    protected $entityLine;
    protected $entityTransformer;
    protected $entityLineTransformer;
    protected $entityForm;
    protected $entityList;
    protected $configService;
    protected $doctypeService;
    protected $entityService;
    protected $showSuccess = false;

    protected $inputs = [
        'number',
        'control_number',
        'order_code',
        'date',
        'description',
        'alter_code',
        //'reference',
        'currency_id',
        'partner_id',
        'doctype_id',
        'price_list_type_id',
        'order_id',
        'tax_id',
        'discount_id',
        'payment_method_id',
    ];

    protected $storeRules = [
        'number' => 'required',
        'doctype_id' => 'required',
        'partner_id'    => 'required|not_in:new',
        'currency_id'    => 'required',
        'date'  => 'required|date',
    ];

    protected $updateRules = [
        'number' => 'required',
        'doctype_id' => 'required',
        'partner_id'    => 'required|not_in:new',
        'date'  => 'required|date',
        'currency_id'    => 'required',
    ];

    protected $storeLineRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'price' => 'required|numeric',
    ];

    protected $updateLineRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'price' => 'required|numeric',
    ];

    protected $lineInputs = [
        'qty',
        'price',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'product_id',
        'tax_id',
        'discount_id',
    ];

    protected $relatedField = 'invoice_id';

    protected $routeBase = 'admin.sales.invoices';

    public function __construct(
        InvoiceForm $entityForm,
        InvoiceList $entityList,
        InvoiceService $entityService,
        ConfigService $configService,
        InvoiceTransformer $entityTransformer,
        InvoiceLineTransformer $entityLineTransformer
    ) {
        $this->entityForm         = $entityForm;
        $this->entityList         = $entityList;
        $this->configService      = $configService;
        $this->entityService      = $entityService;
        $this->entityTransformer  = $entityTransformer;
        $this->entityLineTransformer = $entityLineTransformer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request 
     * @param  int     $id 
     * @return \Illuminate\Http\Response 
     */
    public function edit(Request $request, $id)
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
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (NotLinesException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (CanNotProcessException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        }
    }

    public function cancel($id)
    {
        try {

            $this->entityService->cancel($id);

            flash('Registro anulado exitosamente', 'success', 'success');
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (CanNotProcessException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        }
    }
}
