<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Products\Models\MovementDetail;
use Werp\Modules\Core\Products\Builders\MovementForm;
use Werp\Modules\Core\Products\Builders\MovementList;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Services\MovementService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotDetailException;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Transformers\MovementTransformer;
use Werp\Modules\Core\Products\Transformers\MovementDetailTransformer;

class MovementController extends BaseController
{
    protected $entityForm;
    protected $entityList;
    protected $entityDetail;
    protected $configService;
    protected $entityService;
    protected $doctypeService;
    protected $entityTransformer;
    protected $entityDetailTransformer;
    protected $showSuccess = false;

    protected $inputs = [
        'description',
        'doctype_id',
        'warehouse_from_id',
        'warehouse_to_id',
        'date',
    ];

    protected $storeRules = [
        'doctype_id' => 'required',
        'warehouse_from_id'    => 'required',
        'warehouse_to_id'    => 'required',
        'date'  => 'required|date',
    ];

    protected $updateRules = [
        'doctype_id' => 'required',
        'warehouse_from_id'    => 'required',
        'warehouse_to_id'    => 'required',
        'date'  => 'required|date',
    ];

    protected $storeDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
    ];

    protected $updateDetailRules = [
        'qty'  => 'required|numeric',
        'product_id' => 'required',
    ];

    protected $detailInputs = [
        'qty',
        'product_id',
        'warehouse_from_id',
        'warehouse_to_id'
    ];

    protected $relatedField = 'movement_id';

    protected $routeBase = 'admin.products.movements';

    public function __construct(
        MovementForm $entityForm,
        MovementList $entityList,
        MovementDetail $entityDetail,
        ConfigService $configService,
        MovementService $entityService,
        MovementTransformer $entityTransformer,
        TransactionService $transactionService,
        MovementDetailTransformer $entityDetailTransformer
    ) {
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
        try {

            $entity = $this->entityService->getById($id, false);

            if (!$entity) {
                $entity = $this->entityService->getByCode($id);
            }

            if (!$entity) {
                flash(trans($this->getNotFoundKey()), 'info');
                return back();
            }

            return $this->entityForm->editPage($entity->toArray());

        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return back();

        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return back();
        }
    }

    public function process($id)
    {
        try {

            $this->entityService->process($id);

            flash('Registro procesado exitosamente', 'success', 'success');
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
