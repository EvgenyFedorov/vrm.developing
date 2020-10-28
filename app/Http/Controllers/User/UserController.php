<?php

namespace App\Http\Controllers\User;

use App\Models\Bot\Jobs;
use App\Models\User;
use App\Models\Users\Accesses;
use App\Models\Users\Films;
use App\Models\Users\Mobiles;
use App\Models\Users\Orders;
use App\Models\Users\Programs;
use App\Models\Users\Seances;

class UserController extends RolesController
{
    public function users(){
        return new User();
    }
    public function accesses(){
        return new Accesses();
    }
    public function programs(){
        return new Programs();
    }
    public function seances(){
        return new Seances();
    }
    public function order(){
        return new Orders();
    }
    public function mobiles(){
        return new Mobiles();
    }
    public function films(){
        return new Films();
    }
    public function jobs(){
        return new Jobs();
    }
    public function inputs()
    {
        $this->setInputs();
        return $this->getInputs();
    }
    public function request(){
        return $this->getRequest();
    }
    public function accessDenied(){
        return "ACCESS DENIED!";
    }
}
