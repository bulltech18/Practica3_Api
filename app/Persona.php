<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function usuarios(){
        return $this->hasMany('App\User');
    }
}
