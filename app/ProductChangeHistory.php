<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductChangeHistory extends Model
{
    protected $table = "product_change_history";
    public $timestamps = false;

    public function employee(){
        return $this->belongsTo("App\Employee", "id_employee", "id");
    }
    public function product(){
        return $this->belongsTo("App\Product", "id_product", "id");
    }
    public function groupProduct(){
        return $this->belongsTo("App\Category", "id_group_product", "id");
    }
}
