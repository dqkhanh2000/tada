<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customers";
    protected $fillable = [
        'customer_name', 'address', 'phone', 'id_user', 'gender'
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo("App\User", "id_user", "id");
    }

    public function cart(){
        return $this->hasMany("App\Cart", "id_customer", "id");
    }

    public function order(){
        return $this->hasMany("App\Order", "id_customer", "id");
    }

}
