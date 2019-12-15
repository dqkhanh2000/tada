<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = "producttypes";
    protected $primaryKey = "TypeID";
    public $timestamps = false;

    public function category(){
        return $this->hasMany("App\Category", "TypeID", "TypeID");
    }
}
