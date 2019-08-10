<?php

use Faker\Generator as Faker;
use Werp\Modules\Core\Products\Models\Uom;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Products\Models\Brand;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Category;
use Werp\Modules\Core\Maintenance\Models\Company;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Product::class, function (Faker $faker) {
    return [
        'code' => $faker->numberBetween($min = 10000, $max = 99999),
        'name' => $faker->text($maxNbChars = 30),
        'description' => $faker->text,
        'category_id' => function () {

            if (Category::where('active', BaseModel::STATUS_ACTIVE)->where('type', 'product')->count() < 10) {
                factory(Category::class, 10)->create(['type' => 'product']);
            }

            return Category::where('active', BaseModel::STATUS_ACTIVE)->where('type', 'product')->inRandomOrder()->first()->id;
        },
        'uom_id' => function () {

            if (Uom::where('active', BaseModel::STATUS_ACTIVE)->count() < 10) {
                factory(Uom::class, 10)->create();
            }

            return Uom::where('active', BaseModel::STATUS_ACTIVE)->inRandomOrder()->first()->id;
        },
        'brand_id' => function () {

            if (Brand::where('active', BaseModel::STATUS_ACTIVE)->count() < 10) {
                factory(Brand::class, 10)->create();
            }

            return Brand::where('active', BaseModel::STATUS_ACTIVE)->inRandomOrder()->first()->id;
        },
        'company_id' => function () {
            return Company::where('active', BaseModel::STATUS_ACTIVE)->count() > 0 ?
                Company::inRandomOrder()->first()->id :
                factory(Company::class)->create()->id;
        }, 
        'active' => BaseModel::STATUS_ACTIVE,
    ];
});
