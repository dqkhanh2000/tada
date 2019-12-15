<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewDB extends Model
{
    protected $table = 'views';
    public $timestamps = false;

    public static function count(){
        $curentDate = date('Y-m-d');
        $viewDB = ViewDB::where('Date', $curentDate)->first();
        if($viewDB){
            $viewDB->CountView = $viewDB->CountView +1;
            $viewDB->save();
        }
        else{
            $viewDB = new ViewDB;
            $viewDB->Date = $curentDate;
            $viewDB->CountView = 1;
            $viewDB->save();
        }
    }
}
