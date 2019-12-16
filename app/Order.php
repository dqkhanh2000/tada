<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $primaryKey = "OrderID";
    public $timestamps = false;

    public function orderDetail(){
        return $this->hasMany("App\OrderDetail", "OrderID", "OrderID");
    }

    public function customer(){
        return $this->belongsTo("App\Customer", "CustomerID", "CustomerID");
    }

    public function employee(){
        return $this->belongsTo("App\Employee", "EmployeeID", "EmployeeID");
    }

    public function shippingDetail(){
        return $this->hasOne("App\ShippingDetail", "OrderID", "OrderID");
    }

    public function countTotalOrder(){
        return $this->all()->count();
    }
}
