<?php


namespace App\Repositories\Mobiles;

use App\Models\Users\Mobiles as Model;
use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class MobilesRepository extends CoreRepository
{

    protected function getModelClass(){
        return Model::class;
    }
    public function getMobiles($id){
        return $this->startConditions()->where([['user_id', $id]])->
        orderBy('id', 'asc')->get();
    }
    public function getMobilesSelected($id){
        $mobiles = $this->startConditions()->where([['user_id', $id]])->
        orderBy('id', 'asc')->get();

        return (self::isSelect($mobiles) === false) ? false : $mobiles;

    }
    public static function isSelect($mobiles){
        $status = array();
        foreach ($mobiles as $mobile){
            if($mobile->status == 0){
                $status[] = $mobile->status;
            }
        }

        return (count($status) === count($mobiles)) ? false : true;

    }
}
