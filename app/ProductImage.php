<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = "productimages";
    protected $primaryKey = "ImageID";
    public $timestamps = false;

    public function productByColor(){
        return $this->belongsTo("App\ProductByColor", "ProductByColorID", "ProductByColorID");
    }


}
