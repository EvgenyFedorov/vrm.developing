<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Api\Response;
use App\Models\Users\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    private $roles = null;
    private $request = null;
    private $user = null;
    private $inputs = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->roles = $this->roles()->getRoles();
    }

    public function getRequest(){
        return $this->request;
    }

    // Присваиваем инпуты
    public function setInputs(){
        $this->inputs = $this->request->input();
    }

    // Забираем инпуты
    public function getInputs(){
        return $this->inputs;
    }

    // Возвращаем объект ролей
    public function roles(){
        return new Roles();
    }

    // Записываем юзера
    public function setUser($user = null){
        $this->user = ($user != null) ? $user : $this->request->user();
    }

    // Возвращаем юзера
    public function getUser(){
        return $this->user;
    }

    public function response(){

        return new Response();

    }

    // Проверяем роль, если есть возвращаем массив, если нет FALSE
    public function isRole(){
        $this->setUser();
        if(isset($this->roles[$this->user->roles_id])){
            return [
                'role' => $this->roles[$this->user->roles_id],
                'user' => $this->user
            ];
        }else{
            return false;
        }

    }
}
