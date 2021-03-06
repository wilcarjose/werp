<?php

use Faker\Generator as Faker;
use Werp\Modules\Core\Base\Models\BaseModel;

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

$factory->define(\Werp\Modules\Core\Maintenance\Models\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'active' => BaseModel::STATUS_ACTIVE,
    ];
});
