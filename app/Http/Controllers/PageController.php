<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Category;
use App\Customer;
use App\GroupProduct;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\ProductByColor;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{

    public function home(Request $request){
        $new = GroupProduct::where('Deleted', '=', 0)
                            ->orderBy('DateAdd', 'desc')
                            ->limit(12)
                            ->get();
        $women = GroupProduct::where('Deleted', '=', 0)
                            ->whereRaw("lower(Type) = 'women'")
                        ->orderBy('DateAdd', 'desc')
                        ->limit(12)
                        ->get();

        $men = GroupProduct::where('Deleted', '=', 0)
        ->whereRaw("lower(Type) = 'men'")
                ->orderBy('DateAdd', 'desc')
                ->limit(12)
                ->get();
        $home = true;

        return view("index", compact('home', 'new', 'women', 'men'));
    }

    public function product(){
        $shop = true;

        $product = GroupProduct::where('Deleted', '=', 0)->inRanDomOrder()->get();//->paginate(12);
        return view("product", compact("shop", 'product'));
    }

    public function detail($id){

        $product = GroupProduct::where('GroupNameNoVN', $id)->get()->first();
        return view("detail", compact("id", 'product'));
    }

    public function cart(){

        return view('cart');
    }

    public function order(Request $request){

        $orders = Order::where('CustomerID', $request->session()->get("idCustomer"))->orderBy('OrderDate', 'desc')->paginate(3);
        return view('order', compact('orders'));
    }

    public function search(Request $request){

        $key = $request->get('k');
        $product = GroupProduct::where("Deleted", 0)
                                ->whereRaw("(lower(GroupNameNoVN) like lower('%".$key."%') or lower(GroupName) like lower('%".$key."%'))")
                                ->paginate(12);
        return view('search', compact('product', 'key'));
    }

    public function category($type, $category = null, Request $request){
        $filterQuery = null;
        $orderQuery = null;
        if($request->get('order')){
            $orderBy = $request->get('order');
            switch ($orderBy) {
                case 'price':
                    $orderQuery = "Price";
                    break;
                case 'pricedesc':
                    $orderQuery = "Price desc";
                    break;
                case 'newest':
                    $orderQuery = "DateAdd desc";
                    break;
            }
        }
        if($request->get('filterprice')){
            $filter = $request->get('filterprice');
            switch ($filter) {
                case '100':
                    $filterQuery = "Price <= '100,000₫'";
                    break;
                case '300':
                    $filterQuery = "(Price > '100,000₫' and Price <= '300,000₫')";
                    break;
                case '500':
                    $filterQuery = "(Price > '300,000₫' and Price <= '500,000₫')";
                    break;
                case '1000':
                    $filterQuery = "(Price > '500,000₫' and Price <= '1,000,000₫')";
                    break;
                case 'max':
                    $filterQuery = "(Price > '1,000,000₫')";
                    break;
            }
        }

        $product = null;
        if($category){
            $categoryID = Category::where('CategoryCode', $category)->get();
            if($categoryID->count() > 0)
                $categoryID = $categoryID->first()->CategoryID;
                $product = GroupProduct::whereRaw("lower(Type) like lower('$type')")
                                        ->where("CategoryID",$categoryID)
                                        ->where("Deleted", 0);
                                        // ->get();
        }
        else $product = GroupProduct::whereRaw("lower(Type) like lower('$type')")->where("Deleted", 0);
        if($filterQuery) $product = $product->whereRaw($filterQuery);
        if($orderQuery) $product = $product->orderByRaw($orderQuery);
        $product = $product->paginate(12);
        return view("category", compact('product'));
    }

    public function contact()
    {

        return view('info');
    }

}
