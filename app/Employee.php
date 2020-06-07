<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employees";

    public $timestamps = false;

    public function user(){
        return $this->hasOne("App\User", "id_user", "id");
    }

    public function order(){
        return $this->hasMany("App\Order", "id_employee", "id");
    }

    public function productChangeHistory(){
        return $this->hasMany("App\ProducChangeHistory", "id_employee", "id");
    }

}
