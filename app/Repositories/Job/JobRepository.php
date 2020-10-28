<?php


namespace App\Repositories\Job;

use App\Models\Bot\Jobs as Model;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class JobRepository extends CoreRepository
{
    protected function getModelClass(){
        return Model::class;
    }
    public function getAllIn($where_in){
        return $this->startConditions()
            ->whereIn('user_id', $where_in)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }
    protected function getParamsDefaultJobs(){
        $query[] = ['jobs.id', '>', 0];
        return $query;
    }
    // Возвращаем массив статусов и визуадльных настроек
    public function getStatuses(){

        $objs = null;

        foreach ($this->startConditions()->job_statuses as $job_status){

            $memory_obj = $this->startConditions();

            $memory_obj->text = $job_status['text'];
            $memory_obj->class = $job_status['class'];
            $memory_obj->style = $job_status['style'];

            $objs[] = $memory_obj;
        }
        return $objs;
    }
    // Формируется запрос по фильтру
    public function getData($query, $user_id){

        $query_where[] = ['jobs.id', '>', 0];

        $query_where_in = [];
        $count_where_in = 0;

        $query_where[] = ['user_id', '=', $user_id];

        if(isset($query['program'])){
            if(isset($query['program']['where']['in'])){
                $query_where_in[] = [
                    'name' => 'program_id',
                    'array' => $query['program']['where']['in']
                ];
                $count_where_in = $count_where_in + 1;
            }else{
                $query_where[] = ['program_id', '=', $query['program']['where']];
            }
        }

        if(isset($query['code'])){
            if(isset($query['code']['where']['in'])){
                $query_where_in[] = [
                    'name' => 'code_id',
                    'array' => $query['code']['where']['in']
                ];
                $count_where_in = $count_where_in + 1;
            }else{
                $query_where[] = ['jobs.id', '=', $query['code']['where']];
            }
        }

        // Считаем сколько перечислений в фильтрах, вызываем соответствующий метод
        if($count_where_in == 0){
            return $this->getAll([$query_where]);
        }elseif($count_where_in == 1){
            return $this->getWhereIn1([$query_where], $query_where_in);
        }elseif($count_where_in == 2){
            return $this->getWhereIn2([$query_where], $query_where_in);
        }elseif($count_where_in == 3){
            return $this->getWhereIn3([$query_where], $query_where_in);
        }elseif($count_where_in == 4){
            return $this->getWhereIn4([$query_where], $query_where_in);
        }

    }
    private function getWhereIn1($where, $where_in){
        return $this->startConditions()
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status', 'jobs.enable',
                'programs.id as programs_id', 'programs.name as programs_name','programs.bot_name as programs_bot_name', 'programs.enable as programs_enable',
                'users.id as user_id', 'users.email as users_email', 'users.enable as users_enable')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->leftJoin('users', 'jobs.user_id', '=', 'users.id')
            ->leftJoin('logs', 'jobs.id', '=', 'logs.job_id')
            ->where([$where])
            ->whereIn($where_in[0]['name'], $where_in[0]['array'])
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);
    }
    private function getWhereIn2($where, $where_in){
        return $this->startConditions()
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status', 'jobs.enable',
                'programs.id as programs_id', 'programs.name as programs_name','programs.bot_name as programs_bot_name', 'programs.enable as programs_enable',
                'users.id as user_id', 'users.email as users_email', 'users.enable as users_enable')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->leftJoin('users', 'jobs.user_id', '=', 'users.id')
            ->leftJoin('logs', 'jobs.id', '=', 'logs.job_id')
            ->where([$where])
            ->whereIn($where_in[0]['name'], $where_in[0]['array'])
            ->whereIn($where_in[1]['name'], $where_in[1]['array'])
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);
    }
    private function getWhereIn3($where, $where_in){
        return $this->startConditions()
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status', 'jobs.enable',
                'programs.id as programs_id', 'programs.name as programs_name','programs.bot_name as programs_bot_name', 'programs.enable as programs_enable',
                'users.id as user_id', 'users.email as users_email', 'users.enable as users_enable')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->leftJoin('users', 'jobs.user_id', '=', 'users.id')
            ->leftJoin('logs', 'jobs.id', '=', 'logs.job_id')
            ->where([$where])
            ->whereIn($where_in[0]['name'], $where_in[0]['array'])
            ->whereIn($where_in[1]['name'], $where_in[1]['array'])
            ->whereIn($where_in[2]['name'], $where_in[2]['array'])
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);
    }
    private function getWhereIn4($where, $where_in){
        return $this->startConditions()
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status', 'jobs.enable',
                'programs.id as programs_id', 'programs.name as programs_name','programs.bot_name as programs_bot_name', 'programs.enable as programs_enable',
                'users.id as user_id', 'users.email as users_email', 'users.enable as users_enable')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->leftJoin('users', 'jobs.user_id', '=', 'users.id')
            ->rightJoin('logs', 'jobs.id', '=', 'logs.job_id')
            ->where([$where])
            ->whereIn($where_in[0]['name'], $where_in[0]['array'])
            ->whereIn($where_in[1]['name'], $where_in[1]['array'])
            ->whereIn($where_in[2]['name'], $where_in[2]['array'])
            ->whereIn($where_in[3]['name'], $where_in[3]['array'])
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);
    }
    public function getAll($where){
        return $this->startConditions()
            ->select('jobs.id as jobs_id','jobs.created_at as jobs_created_at','jobs.updated_at as jobs_updated_at','jobs.deleted_at as jobs_deleted_at', 'jobs.enable as jobs_enable', 'jobs.code_id', 'jobs.status', 'jobs.enable',
                'programs.id as programs_id', 'programs.name as programs_name','programs.bot_name as programs_bot_name', 'programs.enable as programs_enable',
                'users.id as user_id', 'users.email as users_email', 'users.enable as users_enable',
                'logs.description as log_desc', 'logs.job_id as logs_job_id', 'logs.id as logs_id')
            ->leftJoin('programs', 'jobs.program_id', '=', 'programs.id')
            ->leftJoin('users', 'jobs.user_id', '=', 'users.id')
            ->leftJoin('logs', 'jobs.id', '=', 'logs.job_id')
            ->where([$where])
            ->orderBy('jobs.id', 'desc')
            ->paginate(10);
    }
    public function getAllForFilter(){
        return $this->startConditions()
            ->select('id', 'code_id')
            ->orderBy('id', 'desc')
            ->get();
    }
    public function getOne($id){
        return $this->startConditions()->find($id);
    }
}
