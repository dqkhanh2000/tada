<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "city";
    public $timestamps = false;

    public function distric(){
        return $this->hasMany("App\Distric", "id", "id");
    }
}
