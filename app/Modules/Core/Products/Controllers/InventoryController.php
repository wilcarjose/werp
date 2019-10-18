<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Models\InventoryLine;
use Werp\Modules\Core\Products\Builders\InventoryForm;
use Werp\Modules\Core\Products\Builders\InventoryList;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Products\Services\InventoryService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Transformers\InventoryTransformer;
use Werp\Modules\Core\Products\Transformers\InventoryLineTransformer;

class InventoryController extends BaseController
{
    protected $entity;
    protected $doctype;
    protected $warehouse;
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
        'date',
        'description',
        'warehouse_id',
        'doctype_id'
    ];

    protected $storeRules = [
        'date' => 'required|date',
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
    ];

    protected $updateRules = [
        'date' => 'required|date',
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
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
        'description',
        'product_id',
        'warehouse_id'
    ];

    protected $relatedField = 'inventory_id';

    protected $routeBase = 'admin.products.inventories';

    public function __construct(
        Product $product,
        Inventory $entity,
        InventoryLine $entityLine,
        InventoryTransformer $entityTransformer,
        InventoryLineTransformer $entityLineTransformer,
        InventoryForm $entityForm,
        InventoryList $entityList,
        Doctype $doctype,
        Warehouse $warehouse,
        ConfigService $configService,
        TransactionService $transactionService,
        InventoryService $entityService
    ) {
        $this->entity            = $entity;
        $this->entityLine      = $entityLine;
        $this->doctype              = $doctype;
        $this->product              = $product;
        $this->warehouse            = $warehouse;
        $this->entityTransformer = $entityTransformer;
        $this->entityLineTransformer = $entityLineTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->configService        = $configService;
        $this->transactionService   = $transactionService;
        $this->entityService     = $entityService;
    }

    protected function getDependencies()
    {
        return [
            'warehouses' => $this->warehouse->all(),
        ];
    }

    protected function getDefaultsDependencies()
    {
        return [
            'warehouse' => $this->configService->getDefaultWarehouse(),
        ];
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

        return $this->entityForm->editPage($entity->toArray(), $this->getDependencies());
    }

    public function process($id)
    {
        try {

            $this->entityService->inventoryId($id)
                ->check()
                ->process();

            flash('Inventario procesado exitosamente', 'success', 'success');
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
