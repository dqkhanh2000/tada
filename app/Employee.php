<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employees";
    protected $primaryKey = "EmployeeID";
    public $timestamps = false;

    public function user(){
        return $this->hasOne("App\User", "UserID", "UserID");
    }

    public function order(){
        return $this->hasMany("App\Order", "EmployeeID", "EmployeeID");
    }

    public function productChangeHistory(){
        return $this->hasMany("App\ProducChangeHistory", "EmployeeID", "EmployeeID");
    }

}
