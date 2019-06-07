<?php

use Faker\Generator as Faker;
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
        'name' => $faker->word,
        'description' => $faker->word,
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'status' => 'active',
    ];
});
