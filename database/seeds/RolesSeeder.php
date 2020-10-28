<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Суперадминистратор', 'Администратор', 'Менеджер', 'Вебмастер'];

        for($i = 0; $i <= 3; $i++){

            if(isset($names[$i])) {
                $data[] = [
                    'name' => $names[$i],
                    'created_at' => date("Y-m-d H:i:s"),
                ];
            }

        }

        DB::table('roles')->insert($data);

    }
}
