<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customers";
    protected $primaryKey = "CustomerID";
    protected $fillable = [
        'CustomerName', 'Address', 'Phone', 'UserID', 'Gender'
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo("App\User", "UserID", "id");
    }

    public function cart(){
        return $this->hasMany("App\Cart", "CustomerID", "CustomerID");
    }

    public function order(){
        return $this->hasMany("App\Order", "CustomerID", "CustomerID");
    }

}
