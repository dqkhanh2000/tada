<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $table = "favoriteproducts";
    public $timestamps = false;

    public function product(){
        return $this->belongsTo("App\Product", "ProductID", "ProductID");
    }

    public function customer(){
        return $this->belongsTo("App\Customer", "CustomerID", "CustomerID");
    }

}


