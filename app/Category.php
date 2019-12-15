<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "CategoryID";
    public $timestamps = false;

    public function groupProduct(){
        return $this->hasMany('App\GroupProduct', 'CategoryID', 'CategoryID');
    }

    public function productType(){
        return $this->belongsTo("App\ProductType", "TypeID", "TypeID");
    }
}
