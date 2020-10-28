<?php

namespace App\Models\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    public function getEditUser(){
        return DB::table('programs')
            ->where([['enable', 1]])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getEditJob($programs){
        return DB::table('programs')
            ->where([['enable', 1]])
            ->whereIn('id', $programs)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getPaginate(){
        return DB::table('programs')
            ->orderBy('programs.id', 'desc')
            ->paginate(10);

    }

//    public function accesses(){
//        return $this->hasMany(Accesses::class, 'privileges', 'id');
//    }

}
