<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Films extends Model
{

    public function order(){
        return $this->hasOne(Orders::class, 'film_id', 'id');
    }

    public function getEditUser(){
        return DB::table('films')
            ->where([['enable', 1]])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getAddedUser($id){
        return DB::table('films')
            ->where([['enable', 1], ['user_id', $id]])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getNotReservedUser(){
        return DB::table('films')
            ->where([['enable', 1], ['user_id', 0]])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getEditJob(){
        return DB::table('films')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getPaginate(){
        return DB::table('films')
            ->orderBy('films.id', 'desc')
            ->get();

    }
}
