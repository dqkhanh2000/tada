<?php
namespace App\Http\Controllers;

use App\GroupProduct;
use App\Category;
use App\ProductByColor;
use App\Http\Resources\GroupProduct as ResourcesGroup;
use App\Http\Resources\Category as ResourcesCategory;
use App\Http\Resources\ProductColor as ResourcesProductByColor;

class ApiController extends Controller{
    function getTopForWomen(){
       return ResourcesGroup::collection(
           GroupProduct::where('Deleted', '=', 0)
                        ->whereRaw("lower(Type) = 'women'")
                        ->orderBy('DateAdd', 'desc')
                        ->limit(6)
                        ->get()
       );
    }
    function getTopForMen(){
        return  ResourcesGroup::collection(
            GroupProduct::where('Deleted', '=', 0)
                        ->whereRaw("lower(Type) = 'men'")
                        ->orderBy('DateAdd', 'desc')
                        ->limit(6)
                        ->get()
        );
    }
    function getCategory(){
        return Category::where('Images', "<>", "NULL")->get();
    }

    function collection($category_code){
        if(Category::where('CategoryCode', $category_code)
        ->get()->first()
        ->groupProduct()
        ->get()->count() == 0) return json_encode([array("count"=>0)]);
        return  ResourcesGroup::collection(
            Category::where('CategoryCode', $category_code)
                ->get()->first()
                ->groupProduct()
                ->where('Deleted', '=', 0)
                ->orderBy('DateAdd', 'desc')
                ->get()
        );
    }

    function getProductByColor($groupProductID){
        return ResourcesProductByColor::collection(
            ProductByColor::where("GroupProductID", $groupProductID)
                ->get()
        );
    }
}
