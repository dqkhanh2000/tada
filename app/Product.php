<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    public $timestamps = false;

    public function productByColor(){
        return $this->belongsTo("App\ProductByColor", "id_product_color", "id");
    }

    public function orderDetail(){
        return $this->hasMany("App\Orderdetail", "id_product", "id");
    }

    public function productChangeHistory(){
        return $this->hasMany("App\Cart", "id_product", "id");
    }

    public function favoriteProduct(){
        return $this->hasMany("App\FavoriteProduct", "id_product", "id");
    }

    public function getGroup(){
        return $this->productByColor()->get()->first()->groupProduct()->get()->first();
    }

}
