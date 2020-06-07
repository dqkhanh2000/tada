<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    public $timestamps = false;

    public function orderDetail(){
        return $this->hasMany("App\OrderDetail", "id_order", "id");
    }

    public function customer(){
        return $this->belongsTo("App\Customer", "id_customer", "id");
    }

    public function employee(){
        return $this->belongsTo("App\Employee", "id_employee", "id");
    }

    public function shippingDetail(){
        return $this->hasOne("App\ShippingDetail", "id_order", "id");
    }

    public function countTotalOrder(){
        return $this->all()->count();
    }
}
