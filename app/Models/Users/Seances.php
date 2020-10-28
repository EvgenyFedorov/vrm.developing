<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Seances extends Model
{
    public function film(){
        return $this->hasOne(Films::class, 'id', 'film_id');
    }
}
