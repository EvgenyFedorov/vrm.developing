<?php


namespace App\Repositories\Program;

use App\Models\Users\Programs as Model;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class ProgramRepository extends CoreRepository
{
    protected function getModelClass(){
        return Model::class;
    }
    public function getAllIn($where_in){
        return $this->startConditions()
            ->whereIn('id', $where_in)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }
    public function getAll($where){
        return $this->startConditions()
            ->where($where)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }
    public function getAllForFilter(){
        return $this->startConditions()
            ->select('id', 'name', 'bot_name')
            ->orderBy('id', 'desc')
            ->get();
    }
    public function getOne($id){
        return $this->startConditions()->find($id);
    }
}
