<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'parent_user' => 3,
        'name' => $faker->firstName,
        'cpabro_login' => $faker->lastName,
        'roles_id' => 4,
        'email' => $faker->email,
        'email_verified_code' => "",
        'password' => bcrypt('root'),
        'enable' => 1,
        'remember_token' => Str::random(10),
        'updated_at' => null,
        'created_at' => date("Y-m-d H:i:s"),
        'deleted_at' => null,
    ];
});
