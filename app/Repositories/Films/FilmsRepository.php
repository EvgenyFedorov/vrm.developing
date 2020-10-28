<?php


namespace App\Repositories\Films;

use App\Models\Users\Films as Model;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class FilmsRepository extends CoreRepository
{

    protected function getModelClass(){
        return Model::class;
    }
    public function getFilms(){
        return $this->startConditions()->where([['enable', 0]])->
        orderBy('id', 'asc')->get();

    }
}
