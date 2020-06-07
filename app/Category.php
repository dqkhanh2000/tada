<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    public $timestamps = false;

    public function groupProduct(){
        return $this->hasMany('App\GroupProduct', 'id_category', 'id');
    }

    public function productType(){
        return $this->belongsTo("App\ProductType", "id_type", "id");
    }
}
