<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $primaryKey = "ProductID";
    public $timestamps = false;

    public function productByColor(){
        return $this->belongsTo("App\ProductByColor", "ProductByColorID", "ProductByColorID");
    }

    public function orderDetail(){
        return $this->hasMany("App\Orderdetail", "ProductID", "ProductID");
    }

    public function productChangeHistory(){
        return $this->hasMany("App\Cart", "ProductID", "ProductID");
    }

    public function favoriteProduct(){
        return $this->hasMany("App\FavoriteProduct", "ProductID", "ProductID");
    }

    public function getGroup(){
        return $this->productByColor()->get()->first()->groupProduct()->get()->first();
    }

}
