<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    protected $table = "shipping_details";
    public $timestamps = false;

    public function order(){
        return $this->belongsTo("App\Order", "id_order", "id");
    }

    public function shipServices(){
        return $this->belongsTo("App\ShipService", "id_ship_service", "id");
    }
}
