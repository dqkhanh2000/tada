<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipService extends Model
{
    protected $table = "ship_services";
    public $timestamps = false;

    public function shippingDetail(){
        return $this->hasMany("App\ShippingDetail", "id_ship_service", "id");
    }
}
