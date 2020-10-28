<?php
/**
 * Created by PhpStorm.
 * User: Fedorov Evgeny
 * Date: 02.11.2018
 * Time: 16:43
 */

namespace App\Models\Api;


class Response{

    public $data = null;
    public $url = null;

    public function Json(){

        return new Json();

    }

}
