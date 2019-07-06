<?php

use Illuminate\Database\Seeder;
use Werp\Modules\Core\Products\Models\Product;

class ManyProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(Product::class, 30)->create();
    }
}
