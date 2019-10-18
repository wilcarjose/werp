<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Werp\Modules\Core\Products\Models\InoutLine;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Products\Builders\ProductOutputForm;
use Werp\Modules\Core\Products\Builders\ProductOutputList;
use Werp\Modules\Core\Products\Services\TransactionService;
use Werp\Modules\Core\Products\Exceptions\NotLinesException;
use Werp\Modules\Core\Products\Services\ProductOutputService;
use Werp\Modules\Core\Products\Transformers\InoutTransformer;
use Werp\Modules\Core\Products\Exceptions\CanNotProcessException;
use Werp\Modules\Core\Products\Transformers\InoutLineTransformer;

class ProductOutputController extends BaseController
{
    protected $entityLine;
    protected $entityTransformer;
    protected $entityLineTransformer;
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
        'product_id',
        'warehouse_id'
    ];

    protected $relatedField = 'inout_id';

    protected $routeBase = 'admin.products.product_output';

    public function __construct(
        InoutLine $entityLine,
        ProductOutputForm $entityForm,
        ProductOutputList $entityList,
        ConfigService $configService,
        ProductOutputService $entityService,
        InoutTransformer $entityTransformer,
        TransactionService $transactionService,
        InoutLineTransformer $entityLineTransformer
    ) {
        $this->entityLine        = $entityLine;
        $this->entityForm         = $entityForm;
        $this->entityList         = $entityList;
        $this->configService      = $configService;
        $this->entityService      = $entityService;
        $this->entityTransformer  = $entityTransformer;
        $this->transactionService = $transactionService;
        $this->entityLineTransformer = $entityLineTransformer;
    }

    public function create()
    {
        return back();
    }

    public function store(Request $request)
    {
        return back();
    }

    public function update(Request $request, $id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
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
            return redirect(route('admin.products.product_output.edit', $id));
        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        } catch (NotLinesException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        } catch (CanNotProcessException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        }
    }

    public function cancel($id)
    {
        try {

            $this->entityService->cancel($id);

            flash('Registro anulado exitosamente', 'success', 'success');
            return redirect(route('admin.products.product_output.edit', $id));
        } catch (ModelNotFoundException $e) {
            flash('Ítem no encontrado, id: '.implode(', ', $e->getIds()), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        } catch (CanNotProcessException $e) {
            flash($e->getMessage(), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        }
    }

    public function print(Request $request, $id)
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

            if ($request->get('view', false) == 'on') {
                return view('admin.pdf.product-output', compact('entity'));
            }

            $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('admin.pdf.product-output', compact('entity'));

            return $pdf->download('product-output.pdf');

        } catch (\Exception $e) {
            flash($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine(), 'error', 'error');
            return redirect(route('admin.products.product_output.edit', $id));
        }

    }
}
