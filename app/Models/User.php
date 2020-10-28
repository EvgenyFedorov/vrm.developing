<?php

namespace App\Models;

use App\Models\Users\Accesses;
use App\Models\Users\TimeZones;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'parent_user', 'roles_id', 'enable', 'email_verified_code', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var $user
     */
    protected $user;

//    // Получаем роль
//    public function roles(){
//        return $this->belongsTo(Roles::class);
//    }

    public static function getArray(){

        return [
            "test1" => 1,
            "test2" => 2,
            "test3" => 3,
        ];

    }

    public function accesses(){
        return $this->hasOne(Accesses::class, 'user_id', 'id');
    }
    public function getPaginate(){
        return DB::table('users')
            ->select(
                'users.id', 'users.name', 'users.roles_id', 'users.email', 'users.enable', 'users.created_at',
                'roles.name',
                'accesses.privileges'
            )
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
            ->leftJoin('accesses', 'users.id', '=', 'accesses.user_id')
            ->orderBy('users.id', 'desc')
            ->paginate(10);

    }

    public function getForSelect(){
        return DB::table('users')
            ->select(
                'users.id', 'users.name', 'users.roles_id', 'users.email', 'users.enable', 'users.created_at',
                'roles.name',
                'accesses.privileges', 'accesses.id as accesses_id'
            )
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
            ->leftJoin('accesses', 'users.id', '=', 'accesses.user_id')
            ->where([['enable', 1]])
            ->orderBy('users.id', 'desc')
            ->get();

    }

    public function getEdit($id){
        return DB::table('users')
            ->select(
                'users.id', 'users.name as users_name', 'users.roles_id', 'users.email', 'users.enable', 'users.created_at',
                'roles.name as roles_name',
                'accesses.privileges', 'accesses.id as accesses_id'
            )
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
            ->leftJoin('accesses', 'users.id', '=', 'accesses.user_id')
            ->where(['users.id' => $id])
            ->limit(1)
            ->get();
    }

    public function set(){

    }

}
