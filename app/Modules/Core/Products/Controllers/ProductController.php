<?php

namespace Werp\Modules\Core\Products\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Werp\Modules\Core\Products\Models\Uom;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Purchases\Models\Partner;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Products\Builders\ProductForm;
use Werp\Modules\Core\Products\Builders\ProductList;
use Werp\Modules\Core\Products\Imports\ProductsImport;
use Werp\Modules\Core\Base\Controllers\BaseController;
use Werp\Modules\Core\Products\Services\ProductService;
use Werp\Modules\Core\Products\Transformers\ProductTransformer;

class ProductController extends BaseController
{
    protected $category;

    protected $brand;

    protected $supplier;

    protected $inputs = [
        'code',
        'name',
        'description',
        'part_number',
        'partner_id',
        'brand_id',
        'category_id',
        'barcode',
        'link',
        'uom_id',
    ];

    protected $storeRules = [
        'code'    => 'required|max:255',
        'name'    => 'required|max:255',
    ];

    protected $updateRules = [
        'name'  => 'required|max:255',
    ];

    protected $routeBase = 'admin.products.products';

    public function __construct(
        ProductService $entityService,
        ProductTransformer $entityTransformer,
        ProductForm $entityForm,
        ProductList $entityList,
        Category $category,
        Partner $supplier,
        Brand $brand
    ) {
        $this->entityService            = $entityService;
        $this->category          = $category;
        $this->supplier          = $supplier;
        $this->brand             = $brand;
        $this->entityTransformer = $entityTransformer;
        $this->entityForm        = $entityForm;
        $this->entityList        = $entityList;
    }

    public function getProductsStock(Request $request)
    {
        $data = $this->entityService->getProductsStock();

        if (empty($data)) {
            return response([
                'status_code' => 404,
            //    'message'     => trans($this->getNotFoundKey())
            ], 404);
        }

        $data = $this->entityTransformer->transformCollection($data);

        return response([
            'data'        => $data,
            //'paginator'   => $paginator,
            'status_code' => 200
        ], 200);
    }

    public function showImport()
    {
        return $this->entityForm->importPage();
    }

    public function import(Request $request) 
    {
        try {

            $rules = [
                'file'  => 'required|file|mimes:csv,xls,xlsx,doc,docx,ppt,pptx,ods,odt,odp',
            ];

            $validator = validator()->make($request->all(), $rules);
        
            if ($validator->fails()) {

                flash(trans($this->getFailValidationKey()), 'error', 'error');
                return back()->withErrors($validator)->withInput();
            }

            Excel::import(new ProductsImport, $request->file('file'));
            
            flash(trans($this->getAddedKey()), 'success', 'success');
            return back();

        } catch (\Exception $e) {

            $message = $e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine();
            flash($message, 'error', 'error');
            return back();
        }
    }
}
