<?php

namespace Werp\Modules\Core\Sales\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Sales\Builders\SaleOrderForm;
use Werp\Modules\Core\Sales\Builders\SaleOrderList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Sales\Services\SaleOrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
use Werp\Modules\Core\Sales\Transformers\SaleOrderTransformer;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Sales\Transformers\SaleOrderLineTransformer;

class SaleOrderController extends BaseController
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
        'description',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'doctype_id',
        'warehouse_id',
        'partner_id',
        'date',
        'price_list_type_id',
        'sale_channel_id',
        'tax_id',
        'discount_id',
        'payment_method_id',
    ];

    protected $storeRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
        'partner_id'    => 'required|not_in:new',
        'price_list_type_id'    => 'required',
        'date'  => 'required|date',
    ];

    protected $updateRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
        'partner_id'    => 'required|not_in:new',
        'date'  => 'required|date',
        'price_list_type_id'    => 'required',
    ];

    protected $storeLineRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
    ];

    protected $updateLineRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
    ];

    protected $lineInputs = [
        'qty',
        'price',
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'product_id',
        'warehouse_id',
        'tax_id',
        'discount_id',
    ];

    protected $relatedField = 'order_id';

    protected $routeBase = 'admin.sales.orders';

    public function __construct(
        SaleOrderForm $entityForm,
        SaleOrderList $entityList,
        SaleOrderService $entityService,
        ConfigService $configService,
        SaleOrderTransformer $entityTransformer,
        SaleOrderLineTransformer $entityLineTransformer
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
     * @param  int  $id
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
