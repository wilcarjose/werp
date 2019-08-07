<?php

namespace Werp\Modules\Core\Sales\Services;

use Illuminate\Support\Facades\DB;
use Werp\Modules\Core\Sales\Models\Price;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Sales\Models\PriceList;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Maintenance\Services\AmountOperationService;

class PriceListService extends BaseService
{
	protected $entity;

    public function __construct(
    	PriceList $entity,
        Price $entityDetail,
        Product $product,
    	DoctypeService $doctypeService,
        AmountOperationService $operationService
    ) {
        $this->entity = $entity;
        $this->product = $product;
        $this->entityDetail = $entityDetail;
        $this->doctypeService = $doctypeService;
        $this->operationService = $operationService;
    }

    public function create(array $data)
    {
        try {

            DB::beginTransaction();

            $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        
            $data = $this->makeUpdateData($data);

            $entity = $this->entity->create($data);

            $this->generatePrices($entity);

            DB::commit();

            return $entity;

        } catch (\Exception $e) {

            DB::rollBack();

            return null;
        }
    }

    public function update($id, $data)
    {
        try {

            DB::beginTransaction();

            $entity = $this->entity->find($id);

            if (!$entity) {
                return false;
            }

            $data = $this->makeUpdateData($data, $id);

            $entity->update($data);

            $this->generatePrices($entity->refresh());

            DB::commit();

            return $entity;

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine());
        }
    }

    protected function makeData($data, $entity = null)
    {
        $priceListType = $entity->priceListType;

        $data['starting_at'] = $entity->starting_at;
        $data['currency'] = $priceListType->currency;
        $data['active'] = BaseModel::STATUS_INACTIVE;
        $data['price_list_type_id'] = $priceListType->id;
        
        return $data;
    }

    protected function makeUpdateData($data, $id = null)
    {

        if (isset($data['reference_price_list_type_id']) && $data['reference_price_list_type_id'] === "0") {
            $data['reference_price_list_type_id'] = null;
        }

        if (isset($data['amount_operation_id']) && $data['amount_operation_id'] === "0") {
            $data['amount_operation_id'] = null;
        }

        return $data;
    }

    public function process($id)
    {
        $entity = $this->getById($id);
        $entity->state = Basedoc::PR_STATE;
        $entity->save();

        $entity->detail()->update(['active' => BaseModel::STATUS_ACTIVE]);
    }

    public function reverse($id)
    {
        $entity = $this->getById($id);
        $entity->state = Basedoc::PE_STATE;
        $entity->save();

        $entity->detail()->update(['active' => BaseModel::STATUS_INACTIVE]);
    }

    public function generatePrices($entity, $products = [])
    {
        $products = is_array($products) ? collect($products) : $products;

        $priceListType = $entity->priceListType;
        $referencePriceListType = $entity->referencePriceListType;

        if ($products->isNotEmpty()) {

            foreach($products as $product) {
                // obtener la operación y pasar como parámetro
                //$total = $this->operationService->setOperation($operation)->calculate($price->price);
                $list = $referencePriceListType ?: $priceListType;
                //\Log::info($list->name);
                $price = $product->currentPrice($list->id);

                $total = $entity->operation ?
                    $this->operationService->setOperation($entity->operation)->calculate($price) :
                    $price;

                $this->deletePrice($entity, $product)->createPrice($entity, $product, $total);
            }

            return true;
        }

        if ($referencePriceListType) {

            $prices = $referencePriceListType->currentPrices();
            
            foreach($prices as $price) {
                // obtener la aperación y pasar como parámetro
                $total = $this->operationService->setOperation($entity->operation)->calculate($price->price);

                $this->deletePrice($entity, $price->product)->createPrice($entity, $price->product, $total);
            }

            return true;
        }

        if ($entity->operation) {

            $prices = $priceListType->prices;

            foreach($prices as $price) {
                // obtener la aperación y pasar como parámetro
                $total = $this->operationService->setOperation($entity->operation)->calculate($price->price);

                $this->deletePrice($entity, $price->product)->createPrice($entity, $price->product, $total);
            }

            return true;
        }
    }

    public function createDetail($id, $data)
    {
        try {

            DB::beginTransaction();

            $entity = $this->getById($id);

            // to do: refactorice
            if (!(!isset($data['product_id']) || (isset($data['product_id']) && $data['product_id'] === "0"))) {

                $product = $this->product->findOrFail($data['product_id']);

                $result = isset($data['price']) && $data['price'] ?
                    $this->deletePrice($entity, $product)->createPrice($entity, $product, $data['price'], true) :
                    $this->generatePrices($entity, [$product]);

                DB::commit();
                return $result;
            }

            if (isset($data['all']) && $data['all']) {

                $products = $this->product->active()->get();
                $result = $this->generatePrices($entity, $products);

                DB::commit();
                return $result;
            }

            if (isset($data['stock']) && $data['stock']) {

            }

            if (isset($data['warehouse_id']) && $data['warehouse_id']) {
                
            }

            if (isset($data['category_id']) && $data['category_id']) {
                
            }

            if (isset($data['brand_id']) && $data['brand_id']) {
                
            }

            DB::commit();
            return $result;

        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }

/*
        [
          "product_id" => "4e9f756e-cf34-409b-bc53-374d25207dec"
          "price" => "232.00"
          "all" => false
          "stock" => true
          "warehouse_id" => "52f2f25d-dfb6-4282-8a30-8b17eb811df7"
          "category_id" => "0"
          "brand_id" => "b621649c-99b1-4ebb-8b1f-babe3e41d653"
        ]
*/
    }

    public function updateDetail($data, $detailId)
    {
        try {

            DB::beginTransaction();

            $entity = $this->entityDetail->findOrFail($detailId)->priceList;

            // to do: refactorice
            if (!(!isset($data['product_id']) || (isset($data['product_id']) && $data['product_id'] === "0"))) {

                $product = $this->product->findOrFail($data['product_id']);

                $result = isset($data['price']) && $data['price'] ?
                    $this->deletePrice($entity, $product)->createPrice($entity, $product, $data['price'], true) :
                    $this->generatePrices($entity, [$product]);

                DB::commit();
                return $result;
            }

            if (isset($data['all']) && $data['all']) {

                $products = $this->product->active()->get();
                $result = $this->generatePrices($entity, $products);

                DB::commit();
                return $result;
            }

            DB::commit();
            return $result;

        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    protected function deletePrice($entity, $product)
    {
        $entity->detail()->inactive()->where('product_id', $product->id)->delete();

        return $this;
    }

    protected function createPrice($entity, $product, $price, $manually = false)
    {
        $basePrice = $entity->referencePriceListType ?
            $product->currentPrice($entity->referencePriceListType->id) :
            0;

        $beforePrice = $product->currentPrice($entity->priceListType->id);

        $operationName = $entity->operation ? $entity->operation->name : null;

        $priceData = [
            'price_list_type_id' => $entity->price_list_type_id,
            'starting_at' => $entity->starting_at,
            'currency' => $entity->priceListType->currency,
            'active' => BaseModel::STATUS_INACTIVE,
            'price' => $price,
            'product_id' => $product->id,
            'before_price' => $beforePrice,
            'base_price' => $manually ? null : $basePrice,
            'amount_operation_id' => $manually ? null : $entity->amount_operation_id,
            'operation_name' => $manually ? null : $operationName,
        ];

        return $entity->detail()->create($priceData);
    }
}
