<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    protected $table = "groupproducts";
    protected $primaryKey = "GroupProductID";
    public $timestamps = false;

    public function category(){
        return $this->belongsTo("App\Category", "CategoryID", "CategoryID");
    }

    public function productByColor(){
        return $this->hasMany("App\ProductByColor", "GroupProductID", "GroupProductID");
    }

    public function productChangeHistory(){
        return $this->hasMany("App\ProductChangeHistory", "GroupProductID", "GroupProductID");
    }

    public function cart(){
        return $this->hasMany("App\Cart", "GroupProductID", "GroupProductID");
    }



}
