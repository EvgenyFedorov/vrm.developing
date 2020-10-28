<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class CoreRepository{

    protected $model;
    public $input;

    public function __construct(Request $request){
        $this->model = app($this->getModelClass());
        $this->input = $request->input();
    }

    abstract protected function getModelClass();

    protected function  startConditions(){
        return clone $this->model;
    }
}
