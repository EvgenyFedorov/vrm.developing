<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Users\Programs::class, function (Faker $faker) {
    return [
        'name' => $faker->text(50),
        'bot_name' => "№" . rand(100,999) . " " . $faker->text(20),
        'enable' => '1',
        'updated_at' => null,
        'created_at' => date("Y-m-d H:i:s"),
        'deleted_at' => null,
    ];
});
