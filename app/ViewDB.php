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
            $viewDB->count_view = $viewDB->count_view +1;
            $viewDB->save();
        }
        else{
            $viewDB = new ViewDB;
            $viewDB->date = $curentDate;
            $viewDB->count_view = 1;
            $viewDB->save();
        }
    }
}
