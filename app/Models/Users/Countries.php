<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Countries extends Model
{
    public function time_zones(){
        return $this->hasOne(TimeZones::class, 'id', 'country_id');
    }
    public static function get($where){
        return DB::table('countries')
            ->where($where)
            ->limit(1)
            ->get();
    }
    public static function getCountries(){

        print "<pre>";

        $url = "https://www.acex.net/ru/useful_information/ISO_country_codes.php";
        $ch = curl_init();

        // отправка запроса
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);

        preg_match('/(?<=<table class=\"add_info\">)[^$]{1,30000}?(?=<\/table>)/', $result, $match_table);
        preg_match_all('/(?<=<tr>)[^$]{1,3000}?(?=<\/tr>)/', $match_table[0], $match_tr);

        if(isset($match_tr[0])) {

            print "<table>";

            print "<tr>
                    <td style='width: 20%;'>АНГЛИЙСКОЕ НАЗВАНИЕ</td>
                    <td style='width: 20%;'>РУССКОЕ НАЗВАНИЕ</td>
                    <td style='width: 20%;'>ISO A2</td>
                    <td style='width: 20%;'>ISO A3</td>
                    <td style='width: 20%;'>ISO №</td>
               </tr>";

            DB::beginTransaction();

            foreach ($match_tr[0] as $value) {

                $new_countries = new Countries();

                if (isset($value)) {

                    print "<tr>";

                    preg_match_all('/(?<=<td>)[^$]{1,1000}?(?=<\/td>)/', $value, $match_tds);

                    if(isset($match_tds[0])){

                        print "<td>{$match_tds[0][1]}</td>";
                        print "<td>{$match_tds[0][0]}</td>";
                        print "<td>{$match_tds[0][2]}</td>";
                        print "<td>{$match_tds[0][3]}</td>";
                        print "<td>{$match_tds[0][4]}</td>";

                        $new_countries->name_en = $match_tds[0][0];
                        $new_countries->name_ru = $match_tds[0][1];

                        $new_countries->iso_a2 = $match_tds[0][2];
                        $new_countries->iso_a3 = $match_tds[0][3];
                        $new_countries->iso_code = $match_tds[0][4];

                        $new_countries->created_at = date("U");

                        $new_countries->save();

                    }

                    print "</tr>";

                }

            }

            DB::commit();

            print "</table>";

        }

    }
}
