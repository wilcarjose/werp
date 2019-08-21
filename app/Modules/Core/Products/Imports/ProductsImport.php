<?php

namespace Werp\Modules\Core\Products\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Werp\Modules\Core\Products\Models\Uom;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Category;

class ProductsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Product([
            'code'     => $row[0],
            'name'    => $row[1], 
            'description' => $row[2],
            'part_number' => $row[3],
            'barcode' => $row[7],
            'link' => $row[8],
            'brand_id' => $this->getBrandId($row[5]),
            'category_id' => $this->getCategoryId($row[6]),
            'uom_id' => $this->getUomId($row[4]),
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