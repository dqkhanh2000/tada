<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = "slider";
    public $timestamps = false;

    public function getLastestSlider(){
        return $this->orderBy('id', 'desc')->take(4)->get();
    }
}
