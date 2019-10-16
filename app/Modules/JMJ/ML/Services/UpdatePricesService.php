<?php

namespace Werp\Modules\JMJ\ML\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\JMJ\ML\Exceptions\UpdatePriceException;

class UpdatePricesService extends BaseService
{
	protected $product;
    protected $mlService;

    public function __construct(Product $product, MLService $mlService)
    {
        $this->product = $product;
        $this->mlService = $mlService;
    }

    public function getPricesByList($listId)
    {
        $prices = [];
        $products = $this->product->where('ml_enabled', true)->active()->get();

        foreach ($products as $product) {
            $prices[] = [
                $product->code,
                $product->ml_item_id,
                $product->name,
                $product->currentPrice($listId)
            ];
        }

        return $prices;
    }

    public function sendMLPrice($mlItemId, $price)
    {
        $params = ['access_token' => session('ml_access_token')];
        $body = ['price' => $price];
        $response = $this->mlService->put('/items/' . $mlItemId, $body, $params);

        if (!isset($response['httpCode']) || $response['httpCode'] != '200') {
            throw new UpdatePriceException($response['body']->message ?? 'Error al actualizar precio');
        }
    }
}

/*
 array:2 [▼
  "body" => {#932 ▼
    +"id": "MLV548514559"
    +"site_id": "MLV"
    +"title": "Control De Directv"
    +"subtitle": null
    +"seller_id": 39975113
    +"category_id": "MLV8894"
    +"official_store_id": null
    +"price": 150000
    +"base_price": 150000
    +"original_price": null
    +"inventory_id": null
    +"currency_id": "VES"
    +"initial_quantity": 1
    +"available_quantity": 1
    +"sold_quantity": 0
    +"sale_terms": array:1 [▶]
    +"buying_mode": "buy_it_now"
    +"listing_type_id": "free"
    +"start_time": "2019-10-09T00:13:13.000Z"
    +"stop_time": "2019-12-07T04:00:00.000Z"
    +"end_time": "2019-12-07T04:00:00.000Z"
    +"expiration_time": null
    +"condition": "used"
    +"permalink": "http://articulo.mercadolibre.com.ve/MLV-548514559-control-de-directv-_JM"
    +"pictures": array:1 [▶]
    +"video_id": null
    +"descriptions": []
    +"accepts_mercadopago": false
    +"non_mercado_pago_payment_methods": []
    +"shipping": {#976 ▶}
    +"international_delivery_mode": "none"
    +"seller_address": {#975 ▶}
    +"seller_contact": null
    +"location": {#982}
    +"geolocation": {#983 ▶}
    +"coverage_areas": []
    +"attributes": array:1 [▶]
    +"warnings": []
    +"listing_source": ""
    +"variations": []
    +"thumbnail": "http://mlv-s2-p.mlstatic.com/768849-MLV32469752287_102019-I.jpg"
    +"secure_thumbnail": "https://mlv-s2-p.mlstatic.com/768849-MLV32469752287_102019-I.jpg"
    +"status": "active"
    +"sub_status": []
    +"tags": []
    +"warranty": "Sin garantía"
    +"catalog_product_id": null
    +"domain_id": null
    +"seller_custom_field": null
    +"parent_item_id": null
    +"differential_pricing": null
    +"deal_ids": []
    +"automatic_relist": false
    +"date_created": "2019-10-09T00:13:13.000Z"
    +"last_updated": "2019-10-09T00:32:18.561Z"
    +"health": null
    +"catalog_listing": false
    +"item_relations": []
  }
  "httpCode" => 200
]
 * */
