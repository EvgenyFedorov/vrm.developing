<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AccessesSeeder::class);

        // Запускаем фабрику и генерируем 10 юзеров
        factory(\App\Models\User::class, 10)->create()->each(function ($user){

            // Запускаем фабрику и генерируем по 1 правам к юзеру
            factory(\App\Models\Users\Accesses::class, 1)->make()->each(function($access) use ($user){
                $access->user_id = $user->id;
                $access->role_id = 4;
                $access->save();
            });

            factory(\App\Models\Users\Programs::class, 1)->create()->each(function ($program) use ($user){

                // Запускаем фабрику и генерируем по рандому задачи
                factory(\App\Models\Bot\Jobs::class, rand(2,6))->make()->each(function($jobs) use ($program, $user){
                    $jobs->program_id = $program->id;
                    $jobs->user_id = $user->id;
                    $jobs->save();
                });

            });

        });

    }
}
