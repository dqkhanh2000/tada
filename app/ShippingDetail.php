<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    protected $table = "shippingdetails";
    protected $primaryKey = "ShippingDetailID";
    public $timestamps = false;

    public function order(){
        return $this->belongsTo("App\Order", "OrderID", "OrderID");
    }

    public function shipServices(){
        return $this->belongsTo("App\ShipService", "ShipServiceID", "ShipServiceID");
    }
}
