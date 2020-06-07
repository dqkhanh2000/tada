<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "order_details";
    public $timestamps = false;

    public function order(){
        $this->belongsTo("App\Order", "id_order", "id");
    }

    public function product(){
        return $this->belongsTo("App\Product", "id_product", "id");
    }
}
