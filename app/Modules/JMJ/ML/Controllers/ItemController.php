<?php

namespace Werp\Modules\JMJ\ML\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\JMJ\ML\Services\ItemService;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(
        ItemService $itemService
    ) {
        $this->itemService     = $itemService;
    }

    public function update(Request $request, $id)
    {
        try {

            $validator = validator()->make($request->all(), [
                'ml_item_id' => 'required_if:ml_enabled,on'
            ]);

            if ($validator->fails()) {
                flash('Ocurrió un error de validación', 'error', 'error');
                return back()->withErrors($validator)->withInput();
            }

            $inputs = [
                'ml_enabled' => $request->input('ml_enabled', 'off'),
                'ml_item_id' => $request->input('ml_item_id', ''),
            ];

            $this->itemService->update($id, $inputs) ?
                flash('Registro actualizado exitosamente', 'success', 'success') :
                flash('Ocurrió un error al actualizar', 'error', 'error');

            $data = [
                'id' => $id
            ];

            if ($request->input('default_tab')) {
                $data['default_tab'] = $request->default_tab;
            }

            return redirect(route('admin.products.products' . '.edit', $data));

        } catch (\Exception $e) {
            flash($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine(), 'error', 'error');
            return redirect(route('admin.products.products' . '.edit', $id));
        }
    }
}
