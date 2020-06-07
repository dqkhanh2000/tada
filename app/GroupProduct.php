<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    protected $table = "group_products";
    public $timestamps = false;

    public function category(){
        return $this->belongsTo("App\Category", "id_category", "id");
    }

    public function productByColor(){
        return $this->hasMany("App\ProductByColor", "id_group_product", "id");
    }

    public function productChangeHistory(){
        return $this->hasMany("App\ProductChangeHistory", "id_group_product", "id");
    }

    public function cart(){
        return $this->hasMany("App\Cart", "id_group_product", "id");
    }



}
