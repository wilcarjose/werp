<?php

namespace Werp\Modules\Core\Maintenance\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Werp\Modules\Core\Base\Models\BaseModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Maintenance\Models\Price;

class PricesImport implements ToModel, WithHeadingRow
{
    protected $priceList;

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $product = $this->getProduct($row['product']);

        $this->priceList->lines()->inactive()->where('product_id', $product->id)->delete();

        $data = [
            'price_list_id' => $this->priceList->id,
            'price_list_type_id' => $this->priceList->price_list_type_id,
            'starting_at' => $this->priceList->starting_at,
            'currency_id' => $this->priceList->priceListType->currency_id,
            'currency_abbr' => $this->priceList->priceListType->currency_abbr,
            'active' => BaseModel::STATUS_INACTIVE,
            'price' => $row['price'],
            'product_id' => $product->id,
            'before_price' => $product->currentPrice($this->priceList->priceListType->id),
            'base_price' => null,
            'amount_operation_id' => null,
            'operation_name' => null,
            'operation_calc' => null,
            'operation_value' => null,
            'exchange_rate_id' => $this->priceList->exchange_rate_id,
        ];

        return new Price($data);
    }

    protected function getProduct($code)
    {
        if (empty($code)) {
            return null;
        }

        return Product::where(['code' => trim($code)])->first();
    }

    public function setPriceList($priceList)
    {
        $this->priceList = $priceList;
        return $this;
    }
}