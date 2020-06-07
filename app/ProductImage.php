<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = "product_images";
    public $timestamps = false;

    public function productByColor(){
        return $this->belongsTo("App\ProductByColor", "id_product_color", "id");
    }


}
