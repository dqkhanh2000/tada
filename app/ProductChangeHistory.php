<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductChangeHistory extends Model
{
    protected $table = "productchangehistory";
    public $timestamps = false;

    public function employee(){
        return $this->belongsTo("App\Employee", "EmployeeID", "EmployeeID");
    }
    public function product(){
        return $this->belongsTo("App\Product", "ProductID", "ProductID");
    }
    public function groupProduct(){
        return $this->belongsTo("App\Category", "GroupProductID", "GroupProductID");
    }
}
