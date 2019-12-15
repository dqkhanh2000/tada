<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = "district";
    public $timestamps = false;

    public function commune(){
        return $this->hasMany("App\Commune", "id", "id");
    }

    public function city(){
        return $this->belongsTo('App\City', 'id', 'id');
    }
}
