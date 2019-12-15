<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "orderdetails";
    protected $primaryKey = "OrderDetailID";
    public $timestamps = false;

    public function order(){
        $this->belongsTo("App\Order", "orderID", "OrderID");
    }

    public function product(){
        return $this->belongsTo("App\Product", "ProductID", "ProductID");
    }
}
