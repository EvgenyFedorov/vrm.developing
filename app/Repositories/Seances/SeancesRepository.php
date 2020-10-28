<?php


namespace App\Repositories\Seances;

use App\Models\Users\Seances as Model;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class SeancesRepository extends CoreRepository
{

    protected function getModelClass(){
        return Model::class;
    }
    public function getSeances($id){
        return $this->startConditions()->where([['user_id', $id]])->
        orderBy('id', 'asc')->get();

    }
}
