<?php

use Faker\Generator as Faker;
use Werp\Modules\Core\Base\Models\BaseModel;
use Werp\Modules\Core\Products\Models\Product;
use Werp\Modules\Core\Products\Models\Category;

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
            return Category::where('type', 'product')->count() > 0 ?
            	Category::where('type', 'product')->first()->id :
            	factory(Category::class)->create(['type' => 'product'])->id;
        },
        'active' => BaseModel::STATUS_ACTIVE,
    ];
});
