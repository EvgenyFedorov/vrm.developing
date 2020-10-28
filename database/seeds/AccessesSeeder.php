<?php

use Illuminate\Database\Seeder;

class AccessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i = 1; $i <= 3; $i++){

            if(isset($i)) {

                $programs = [];

                for($p=1; $p <= 11; $p++){

                    $program_id = rand(1,10);

                    if(!in_array($program_id, $programs)){
                        $programs[] = $program_id;
                    }

                }

                $data[] = [
                    'user_id' => $i,
                    'role_id' => $i,
                    'privileges' => json_encode(["show_programs" => $programs]),
                    'created_at' => date("Y-m-d H:i:s"),
                ];

            }

        }

        DB::table('accesses')->insert($data);
    }
}
