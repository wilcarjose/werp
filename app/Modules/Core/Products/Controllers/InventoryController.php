<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\BaseController;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Inventory;
use Werp\Modules\Core\Products\Models\Warehouse;
use Werp\Modules\Core\Maintenance\Models\Doctype;
use Werp\Modules\Core\Products\Models\InventoryDetail;
use Werp\Modules\Core\Products\Builders\InventoryForm;
use Werp\Modules\Core\Products\Builders\InventoryList;
use Werp\Modules\Core\Products\Services\ConfigService;
use Werp\Modules\Core\Products\Services\InventoryService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Transformers\InventoryTransformer;
use Werp\Modules\Core\Products\Transformers\InventoryDetailTransformer;

class InventoryController extends BaseController
{
    protected $entity;
    protected $doctype;
    protected $warehouse;
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
        'warehouse_id',
        'doctype_id'
    ];

    protected $storeRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
    ];

    protected $updateRules = [
        'doctype_id' => 'required',
        'warehouse_id'    => 'required',
    ];

    protected $storeDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'warehouse_id' => 'required',
    ];

    protected $updateDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
        'warehouse_id' => 'required',
    ];

    protected $detailInputs = [
        'qty',
        'description',
        'product_id',
        'warehouse_id'
    ];

    protected $relatedField = 'inventory_id';

    public function __construct(
        Product $product,
        Inventory $entity,
        InventoryDetail $entityDetail,
        InventoryTransformer $entityTransformer,
        InventoryDetailTransformer $entityDetailTransformer,
        InventoryForm $entityForm,
        InventoryList $entityList,
        Doctype $doctype,
        Warehouse $warehouse,
        ConfigService $configService,
        DoctypeService $doctypeService,
        TransactionService $transactionService,
        InventoryService $entityService
    ) {
        $this->entity            = $entity;
        $this->entityDetail      = $entityDetail;
        $this->doctype              = $doctype;
        $this->product              = $product;
        $this->warehouse            = $warehouse;
        $this->entityTransformer = $entityTransformer;
        $this->entityDetailTransformer = $entityDetailTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
        $this->configService        = $configService;
        $this->doctypeService       = $doctypeService;
        $this->transactionService   = $transactionService;
        $this->entityService     = $entityService;
    }

    protected function getDependencies()
    {
        return [
            'doctypes' => $this->doctype->all(),
            'warehouses' => $this->warehouse->all(),
        ];
    }

    protected function getDefaultsDependencies()
    {
        return [
            'doctype' => $this->configService->getDefaultInventaryDoctype(),
            'warehouse' => $this->configService->getDefaultWarehouse(),
        ];
    }

    public function process($id)
    {
        try {

            $this->entityService->inventoryId($id)
                ->check()
                ->process();

            flash('Inventario procesado exitosamente', 'success', 'success');
            return redirect(route('admin.products.inventories.edit', $id));

        } catch (NotDetailException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.inventories.edit', $id));
        } catch (CanNotProcessException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.inventories.edit', $id));
        } catch (\Exception $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.inventories.edit', $id));
        }
    }
}
