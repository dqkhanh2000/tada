<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $table = "favorite_products";
    public $timestamps = false;

    public function product(){
        return $this->belongsTo("App\Product", "id_product", "id");
    }

    public function customer(){
        return $this->belongsTo("App\Customer", "id_customer", "id");
    }

}


