<?php

namespace Werp\Modules\Core\Products\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Werp\Modules\Core\Products\Models\Uom;
use Werp\Modules\Core\Products\Models\Brand;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Category;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Product([
            'code'     => $row['code'],
            'name'    => $row['name'], 
            'description' => $row['description'],
            'part_number' => $row['part_number'],
            'barcode' => $row['barcode'],
            'link' => $row['link'],
            'brand_id' => $this->getBrandId($row['brand']),
            'category_id' => $this->getCategoryId($row['category']),
            'uom_id' => $this->getUomId($row['uom']),
        ]);
    }

    protected function getBrandId($name)
    {
        if (empty($name)) {
            return null;
        }

        $brand = Brand::firstOrCreate(['name' => trim($name)]);

        return $brand->id;
    } 

    protected function getCategoryId($name)
    {
        if (empty($name)) {
            return null;
        }

        $brand = Category::firstOrCreate([
          'name' => trim($name),
          'type' => Category::PRODUCT_TYPE
        ]);

        return $brand->id;
    } 

    protected function getUomId($name)
    {
        if (empty($name)) {
            return null;
        }

        $brand = Uom::firstOrCreate(['name' => trim($name)]);

        return $brand->id;
    } 
}