<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductByColor extends Model
{
    //
    protected $table = "product_colors";
    public $timestamps = false;

    public function groupProduct(){
        return $this->belongsTo("App\GroupProduct", "id_group_product", "id");
    }

    public function product(){
        return $this->hasMany("App\Product", "id_product_color", "id");
    }

    public function productImage(){
        return $this->hasMany("App\ProductImage", "id_product_color", "id");
    }
}
