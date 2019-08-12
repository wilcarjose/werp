<?php

namespace Werp\Modules\Core\Purchases\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Purchases\Builders\PurchaseOrderForm;
use Werp\Modules\Core\Purchases\Builders\PurchaseOrderList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Purchases\Services\PurchaseOrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Purchases\Transformers\PurchaseOrderTransformer;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Purchases\Transformers\PurchaseOrderDetailTransformer;

class PurchaseOrderController extends BaseController
{
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
        'total_price',
        'total_tax',
        'total_discount',
        'total',
        'currency',
        'doctype_id',
        'warehouse_id',
        'partner_id',
        'date',
        'price_list_type_id',
        'tax_id',
        'discount_id',
        'payment_method_id',
    ];

    protected $storeRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
        'partner_id'    => 'required',
        'price_list_type_id'    => 'required',
        'date'  => 'required|date',
    ];

    protected $updateRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
        'partner_id'    => 'required',
        'date'  => 'required|date',
        'price_list_type_id'    => 'required',
    ];

    protected $storeDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'price' => 'required',
    ];

    protected $updateDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'price' => 'required',
    ];

    protected $detailInputs = [
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

    protected $routeBase = 'admin.purchases.orders';

    public function __construct(
        PurchaseOrderForm $entityForm,
        PurchaseOrderList $entityList,
        PurchaseOrderService $entityService,
        ConfigService $configService,
        PurchaseOrderTransformer $entityTransformer,
        PurchaseOrderDetailTransformer $entityDetailTransformer        
    ) {
        $this->entityForm         = $entityForm;
        $this->entityList         = $entityList;
        $this->configService      = $configService;
        $this->entityService      = $entityService;
        $this->entityTransformer  = $entityTransformer;
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
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return redirect(route($this->routeBase.'.edit', $id));
        } catch (NotDetailException $e) {
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
