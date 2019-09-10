<?php

namespace Werp\Modules\Core\Sales\Services;

use Werp\Modules\Core\Sales\Models\Price;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Sales\Models\PriceList;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Models\Basedoc;
use Werp\Modules\Core\Maintenance\Models\ExchangeRate;
use Werp\Modules\Core\Maintenance\Services\ConfigService;
use Werp\Modules\Core\Maintenance\Services\DoctypeService;
use Werp\Modules\Core\Sales\Services\PriceListTypeService;
use Werp\Modules\Core\Maintenance\Services\ExchangeRateService;
use Werp\Modules\Core\Maintenance\Services\AmountOperationService;

class PriceListService extends BaseService
{
	protected $entity;

    public function __construct(
        Product $product,
    	PriceList $entity,
        Price $entityDetail,
        ConfigService $configService,
    	DoctypeService $doctypeService,
        //ExchangeRateService $exchangeService,
        AmountOperationService $operationService,
        PriceListTypeService $priceListTypeService
    ) {
        $this->entity           = $entity;
        $this->product          = $product;
        $this->entityDetail     = $entityDetail;
        $this->doctypeService   = $doctypeService;
        $this->configService    = $configService;
        //$this->exchangeService  = $exchangeService;
        $this->operationService = $operationService;
        $this->priceListTypeService = $priceListTypeService;
    }

    public function create(array $data)
    {
        try {

            $this->begin();

            $entity = $this->createPriceList($data);

            $this->generatePrices($entity);

            $this->commit();

            return $entity;

        } catch (\Exception $e) {

            $this->rollback();

            throw new \Exception($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine());
        }
    }

    public function createPriceList(array $data)
    {
        $data['code'] = $this->doctypeService->nextDocNumber($data['doctype_id']);
        
        $useExchange = isset($data['use_exchange_rate']) && $data['use_exchange_rate'] == 'on';

        $data = $this->makeUpdateData($data);

        $entity = $this->entity->create($data);

        $entity = $this->setExchange($entity, $useExchange);

        return $entity;
    }

    public function update($id, $data)
    {
        try {

            $this->begin();

            $entity = $this->entity->find($id);

            if (!$entity) {
                return false;
            }

            $data = $this->makeUpdateData($data, $id);

            $useExchange = isset($data['use_exchange_rate']) && $data['use_exchange_rate'] == 'on';

            $entity->update($data);

            $entity = $this->setExchange($entity, $useExchange);

            $this->generatePrices($entity);

            $this->commit();

            return $entity;

        } catch (\Exception $e) {

            $this->rollback();

            throw new \Exception($e->getMessage(). ' - '.$e->getFile(). ' - '.$e->getLine());
        }
    }

    protected function makeData($data, $entity = null)
    {
        $priceListType = $entity->priceListType;

        $data['starting_at'] = $entity->starting_at;
        $data['currency_id'] = $priceListType->currency_id;
        $data['active'] = BaseModel::STATUS_INACTIVE;
        $data['price_list_type_id'] = $priceListType->id;
        
        return $data;
    }

    protected function makeUpdateData($data, $id = null)
    {
        return $data;
    }

    protected function setExchange($entity, $useExchange)
    {
        if ($useExchange && $entity->referencePriceListType) {

            $exchangeName = $entity->referencePriceListType->currency->abbr .'/'.$entity->priceListType->currency->abbr;
            //$exchange = $this->exchangeService->getByName($exchangeName);
            $exchange = ExchangeRate::where('name', $exchangeName)->orderBy('starting_at', 'desc')->first();

            if ($exchange) {
                $entity->exchange_rate_id = $exchange->id;
                $entity->amount_operation_id = null;
                $entity->save();

                return $entity;
            }            
        }

        $entity->exchange_rate_id = null;
        $entity->save();

        return $entity;
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

        if ($products->isNotEmpty()) {

            foreach($products as $product) {
                //$total = $this->operationService->setOperation($operation)->calculate($price->price);
                $list = $entity->referencePriceListType ?: $entity->priceListType;
                //\Log::info($list->name);
                $price = $product->currentPriceObject($list->id);

                $amount = $this->getPrice($entity, $price);

                $this->deletePrice($entity, $product)->createPrice($entity, $product, $amount);
            }

            return true;
        }

        if ($entity->referencePriceListType) {

            $prices = $entity->referencePriceListType->currentPrices();
            
            foreach($prices as $price) {

                $amount = $this->getPrice($entity, $price, true);

                $this->deletePrice($entity, $price->product)->createPrice($entity, $price->product, $amount);
            }

            return true;
        }

        if ($entity->operation) {

            $prices = $entity->priceListType->currentPrices();

            foreach($prices as $price) {
                // obtener la aperación y pasar como parámetro
                $amount = $this->operationService->setOperation($entity->operation)->calculate($price->price);

                $this->deletePrice($entity, $price->product)->createPrice($entity, $price->product, $amount);
            }

            return true;
        }

        $prices = $entity->priceListType->currentPrices();

        foreach($prices as $price) {
            $amount = $price->product->currentPrice($entity->priceListType->id);
            $this->deletePrice($entity, $price->product)->createPrice($entity, $price->product, $amount);
        }

        return true;
    }

    protected function getPrice($entity, $price, $useReferenceList = false)
    {
        if ($entity->exchangeRate) {

            $operation = $this->operationService->getByName($entity->exchangeRate->name);

            if ($operation) {
                return $this->operationService->setOperation($operation)->calculate($price->price);
            }

            return $entity->exchangeRate->value * $price->price;
            //return $this->exchangeService->exchangePrice($entity->exchangeRate, $price->price);
        }

        if ($entity->operation) {
            return $this->operationService->setOperation($entity->operation)->calculate($price->price);
        }

        if ($useReferenceList && $entity->referencePriceListType) {
            return $price->product->currentPrice($entity->referencePriceListType->id);
        }

        return $price->price;
    }

    public function createDetail($id, $data)
    {
        try {

            $this->begin();

            $entity = $this->getById($id);

            // to do: refactorice
            if (!(!isset($data['product_id']) || (isset($data['product_id']) && $data['product_id'] === "0"))) {

                $product = $this->product->findOrFail($data['product_id']);

                $result = isset($data['price']) && $data['price'] ?
                    $this->deletePrice($entity, $product)->createPrice($entity, $product, $data['price'], true) :
                    $this->generatePrices($entity, [$product]);

                $this->commit();
                return $result;
            }

            if (isset($data['all']) && $data['all']) {

                $products = $this->product->active()->get();
                $result = $this->generatePrices($entity, $products);

                $this->commit();
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

            $this->commit();
            return $result;

        } catch (\Exception $e) {

            $this->rollback();
            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    public function updateDetail($data, $detailId)
    {
        try {

            $this->begin();

            $entity = $this->entityDetail->findOrFail($detailId)->priceList;

            // to do: refactorice
            if (!(!isset($data['product_id']) || (isset($data['product_id']) && $data['product_id'] === "0"))) {

                $product = $this->product->findOrFail($data['product_id']);

                $result = isset($data['price']) && $data['price'] ?
                    $this->deletePrice($entity, $product)->createPrice($entity, $product, $data['price'], true) :
                    $this->generatePrices($entity, [$product]);

                $this->commit();
                return $result;
            }

            if (isset($data['all']) && $data['all']) {

                $products = $this->product->active()->get();
                $result = $this->generatePrices($entity, $products);

                $this->commit();
                return $result;
            }

            $this->commit();
            return $result;

        } catch (\Exception $e) {

            $this->rollback();
            throw new \Exception("Error Processing Request: ".$e->getMessage() . ' - ' . $e->getFile() . ' - ' . $e->getLine());
        }
    }

    protected function deletePrice($entity, $product)
    {
        $entity->detail()->inactive()->where('product_id', $product->id)->delete();

        return $this;
    }

    public function createPrice($entity, $product, $price, $manually = false)
    {
        $basePrice = $entity->referencePriceListType ?
            $product->currentPrice($entity->referencePriceListType->id) :
            0;

        $beforePrice = $product->currentPrice($entity->priceListType->id);

        $operationName = $entity->operation ? $entity->operation->name : null;
        $operationCalc = $entity->operation ? $entity->operation->operation : null;
        $operationValue = $entity->operation ? 
            ($entity->operation->config_key ? $this->configService->getValue($entity->operation->config_key) : $entity->operation->value) :
            null;

        if ($entity->exchangeRate) {
            $operationName = $entity->exchangeRate->name;
            $operationCalc = 'multiply';
            $operationValue = $entity->exchangeRate->value;
        }

        $priceData = [
            'price_list_type_id' => $entity->price_list_type_id,
            'starting_at' => $entity->starting_at,
            'currency_id' => $entity->priceListType->currency_id,
            'currency_abbr' => $entity->priceListType->currency_abbr,
            'active' => BaseModel::STATUS_INACTIVE,
            'price' => $price,
            'product_id' => $product->id,
            'before_price' => $beforePrice,
            'base_price' => $manually ? null : $basePrice,
            'amount_operation_id' => $manually ? null : $entity->amount_operation_id,
            'operation_name' => $manually ? null : $operationName,
            'operation_calc' => $manually ? null : $operationCalc,
            'operation_value' => $manually ? null : $operationValue,
            'exchange_rate_id' => $entity->exchange_rate_id,
        ];

        return $entity->detail()->create($priceData);
    }

    public function generateFromExchange($exchange)
    {
        try {

            $this->begin();

            $data = [
                'starting_at' => date('Y-m-d H:i:s'),
                'description' => 'Created from exchange rate: '. $exchange->name,
                'price_list_type_id' => $this->priceListTypeService->getPriceListByCurrency($exchange->currency_to_id)->id,
                'doctype_id' => $this->configService->getDefaultPriceListDoctype(),
                'reference_price_list_type_id' => $this->priceListTypeService->getPriceListByCurrency($exchange->currency_from_id)->id,
                'use_exchange_rate' => 'on'
            ];

            $entity = $this->createPriceList($data);

            $this->generatePrices($entity);

            $this->process($entity->id);

            $this->commit();

            return $entity;

        } catch (\Exception $e) {

            $this->rollback();

            throw new \Exception($e->getMessage().' - '.$e->getFile() . ' - ' .$e->getLine());
        }
    }
}
