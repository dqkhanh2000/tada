<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipService extends Model
{
    protected $table = "shipservices";
    protected $primaryKey = "ShipServiceID";
    public $timestamps = false;

    public function shippingDetail(){
        return $this->hasMany("App\ShippingDetail", "ShipServiceID", "ShipServiceID");
    }
}
