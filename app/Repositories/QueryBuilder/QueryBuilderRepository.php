<?php


namespace App\Repositories\QueryBuilder;

use App\Models\Filter\Filter as Model;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class QueryBuilderRepository extends CoreRepository
{

    protected function getModelClass(){
        return Model::class;
    }
    protected function getParamsDefaultJobs(){
        $queries = [];
        $queries['where'][] = ['jobs.id', '>', 0];
        return $queries;
    }
    public function getParamsQueryJobs(){

        $queries = array();

        if(!isset($this->input['email']) && !isset($this->input['cpabro_login']) && !isset($this->input['program']) && !isset($this->input['code'])){
            $queries = $this->getParamsDefaultJobs();
        }

        // Проверяем выбранные фильтры для корректной пагинации
        if(isset($this->input['email'])){
            $explode = explode(',', $this->input['email']);
            if(isset($explode[0]) && count($explode) > 1){
                $queries['email']['where']['in'] = $explode;
            }else{
//                $queries['email']['where'][] = ['user_id', $this->input['email']];
                $queries['email']['where'][] = $this->input['email'];
            }
        }

        if(isset($this->input['cpabro_login'])){
            $explode = explode(',', $this->input['cpabro_login']);
            if(isset($explode[0]) && count($explode) > 1){
                $queries['cpabro_login']['where']['in'] = $explode;
            }else{
//                $queries['cpabro_login']['where'][] = ['user_id', $this->input['cpabro_login']];
                $queries['cpabro_login']['where'][] = $this->input['cpabro_login'];
            }
        }

        if(isset($this->input['program'])){
            $explode = explode(',', $this->input['program']);
            if(isset($explode[0]) && count($explode) > 1){
                $queries['program']['where']['in'] = $explode;
            }else{
//                $queries['program']['where'][] = ['program_id', $this->input['program']];
                $queries['program']['where'][] = $this->input['program'];
            }
        }

        if(isset($this->input['code'])){
            $explode = explode(',', $this->input['code']);
            if(isset($explode[0]) && count($explode) > 1){
                $queries['code']['where']['in'] = $explode;
            }else{
//                $queries['code']['where'][] = ['code_id', $this->input['code']];
                $queries['code']['where'][] = $this->input['code'];
            }
        }

        return $queries;

    }
    protected function getParamsDefaultUsers(){
        $queries = [];
        $queries['where'][] = ['id', '>', 0];
        return $queries;
    }
    public function getParamsQueryUsers(){

        $queries = array();

        if(!isset($this->input['email']) && !isset($this->input['cpabro_login'])){
            $queries = $this->getParamsDefaultUsers();
        }

        // Проверяем выбранные фильтры для корректной пагинации
        if(isset($this->input['email'])){
            $explode = explode(',', $this->input['email']);
            if(isset($explode[0]) && count($explode) > 1){
                $queries['where']['in'] = $explode;
            }else{
                $queries['where'][] = ['id', $this->input['email']];
            }
        }

        if(isset($this->input['cpabro_login'])){
            $explode = explode(',', $this->input['cpabro_login']);
            if(isset($explode[0]) && count($explode) > 1){
                $queries['where']['in'] = $explode;
            }else{
                $queries['where'][] = ['id', $this->input['cpabro_login']];
            }
        }

        return $queries;

    }

}
