<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Mobiles extends Model
{

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function seance(){
        return $this->hasOne(Seances::class, 'id', 'seances_id');
    }

    public function getEditUser(){
        return DB::table('mobiles')
            ->where([['enable', 1]])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getAddedUser($id){
        return DB::table('mobiles')
            ->where([['enable', 1], ['user_id', $id]])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getNotReservedUser(){
        return DB::table('mobiles')
            ->where([['enable', 1], ['user_id', 0]])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getEditJob(){
        return DB::table('mobiles')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getPaginate($id){
        return DB::table('mobiles')
            ->where([['enable', 1], ['user_id', $id]])
            ->orderBy('mobiles.id', 'desc')
            ->paginate(10);

    }
}
