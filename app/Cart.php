<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = "carts";
    public $timestamps = false;
    public function product(){
        return $this->belongsTo("App\Product", "id_product", "id");
    }
    public function customer(){
        return $this->belongsTo("App\Customer", "id_customer", "id");
    }
}
