<?php

namespace App\Http\Controllers;

use App\Category;
use App\Commune;
use App\District;
use Illuminate\Http\Request;

class AddressController extends Controller{

    public function district(Request $request){
        $id = $request->id;
        if($id<10) $id = '0'.$id;
        $data = District::where('matp', '=', $id)->select("id as id", "name as text")->get();
        return $data;
    }

    public function commune(Request $request){
        $id = $request->id;
        if($id<10) $id = '00'.$id;
        else if($id<100) $id = '0'.$id;
        $data = Commune::where('maqh', '=', $id)->select("id as id", "name as text")->get();
        return $data;
    }
}
