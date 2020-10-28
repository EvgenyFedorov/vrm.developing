<?php


namespace App\Repositories\Filter;

use App\Models\Filter\Filter as Model;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class FilterRepository extends CoreRepository
{

    protected function getModelClass(){
        return Model::class;
    }
    public function getParams(){
        return $this->getParamsSearch();
    }
    public function getParamsSearch(){

        $params = [];
        $in = [];

        // Проверяем выбранные фильтры для корректной пагинации
        if(isset($this->input['email'])){
            $explode = explode(',', $this->input['email']);
            if(isset($explode[0]) && count($explode) > 1) {
                $params['email']['in'] = $explode;
            }else{
                $params['email'] = $this->input['email'];
            }
        }
        if(isset($this->input['cpabro_login'])){
            $explode = explode(',', $this->input['cpabro_login']);
            if(isset($explode[0]) && count($explode) > 1) {
                $params['cpabro_login']['in'] = $explode;
            }else{
                $params['cpabro_login'] = $this->input['cpabro_login'];
            }
        }
        if(isset($this->input['program'])){
            $explode = explode(',', $this->input['program']);
            if(isset($explode[0]) && count($explode) > 1) {
                $params['program']['in'] = $explode;
            }else{
                $params['program'] = $this->input['program'];
            }
        }
        if(isset($this->input['code'])){
            $explode = explode(',', $this->input['code']);
            if(isset($explode[0]) && count($explode) > 1) {
                $params['code']['in'] = $explode;
            }else{
                $params['code'] = $this->input['code'];
            }
        }

        return $params;

    }
}
