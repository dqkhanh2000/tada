<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = "product_types";
    public $timestamps = false;

    public function category(){
        return $this->hasMany("App\Category", "id_type", "id");
    }
}
