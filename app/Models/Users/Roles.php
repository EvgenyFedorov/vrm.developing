<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function accesses(){
        return $this->hasOne(Accesses::class);
    }
    public function user(){
        return $this->hasOne(User::class);
    }
    public function getRoles(){
        return [
//            1 => [
//                'name' => 'Суперадминистратор',
//                'dir' => 'SupperAdmin',
//                'class' => '\\App\\Http\\Controllers\\User\\SupperAdmin\\SupperAdminController'
//            ],
//            2 => [
//                'name' => 'Администратор',
//                'dir' => 'Admin',
//                'class' => '\\App\\Http\\Controllers\\User\\Admin\\AdminController'
//            ],
//            3 => [
//                'name' => 'Менеджер',
//                'dir' => 'Manager',
//                'class' => '\\App\\Http\\Controllers\\User\\Manager\\ManagerController'
//            ],
            4 => [
                'name' => 'Вебмастер',
                'dir' => 'Webmaster',
                'class' => '\\App\\Http\\Controllers\\User\\Webmaster\\WebmasterController'
            ]
        ];
    }

}
