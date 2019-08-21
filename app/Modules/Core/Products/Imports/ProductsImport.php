<?php

namespace Werp\Modules\Core\Products\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Werp\Modules\Core\Products\Models\Product;

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
        ]);
    }
}