<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Users\Accesses::class, function (Faker $faker) {
    return [
        'privileges' => function(){

            $programs = [];

            for($p=1; $p <= 11; $p++){

                $program_id = rand(1,10);

                if(!in_array($program_id, $programs)){
                    $programs[] = $program_id;
                }

            }

            return json_encode(["show_programs" => $programs]);
        },
        'updated_at' => null,
        'created_at' => date("Y-m-d H:i:s"),
        'deleted_at' => null,
    ];
});
