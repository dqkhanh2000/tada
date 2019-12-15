<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $table = "commune";
    public $timestamps = false;

    public function distric(){
        return $this->belongsTo("App\Distric", "id", "id");
    }
}
