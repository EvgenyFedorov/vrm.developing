<?php

namespace App\Models\Bot;

use App\Models\User;
use App\Models\Users\Programs;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{

    private $id = null;
    private $program_id = null;
    private $user_id = null;
    private $code_id = null;
    private $status = null;
    private $enable = null;
    private $created_at = null;
    private $updated_at = null;
    private $deleted_at = null;

    public $text = null;
    public $class = null;
    public $style = null;

    public $job_statuses = [
        [
            'text' => 'Ожидает',
            'class' => 'btn-info',
            'style' => 'cursor: no-drop;'
        ],
        [
            'text' => 'Отгружен',
            'class' => 'btn-success',
            'style' => 'cursor: help;'
        ],
        [
            'text' => 'Неуспешно',
            'class' => 'btn-danger',
            'style' => 'cursor: help;'
        ],
    ];

    public function getEdit($id){
        return DB::table('jobs')
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status', 'jobs.enable',
                'programs.id as programs_id', 'name','bot_name',
                'jobs.code_id', 'jobs.status')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->where([['user_id', $id]])
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);

    }
    public function getEditOne($id){
        return DB::table('jobs')
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status',
                'programs.id as programs_id', 'programs.name as programs_name','bot_name',
                'users.id as user_id', 'users.email as users_email', 'roles.name as roles_name')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->leftJoin('users', 'jobs.user_id', '=', 'users.id')
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
            ->where([['jobs.id', $id]])
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);

    }
    public function getAll(){
        return DB::table('jobs')
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status', 'jobs.enable',
                'programs.id as programs_id', 'programs.name as programs_name','bot_name',
                'users.id as user_id', 'users.email as users_email')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->leftJoin('users', 'jobs.user_id', '=', 'users.id')
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);

    }
    public function programs(){
        return $this->hasOne(Programs::class, 'program_id', 'id');
    }
    public function users(){
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
