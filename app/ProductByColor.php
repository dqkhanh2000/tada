<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductByColor extends Model
{
    //
    protected $table = "productbycolors";
    protected $primaryKey = "ProductByColorID";
    public $timestamps = false;

    public function groupProduct(){
        return $this->belongsTo("App\GroupProduct", "GroupProductID", "GroupProductID");
    }

    public function product(){
        return $this->hasMany("App\Product", "ProductByColorID", "ProductByColorID");
    }

    public function productImage(){
        return $this->hasMany("App\ProductImage", "ProductByColorID", "ProductByColorID");
    }
}
