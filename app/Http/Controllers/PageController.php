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
use App\ProductType;
use App\ProductByColor;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{

    public function home(Request $request){
        $new = GroupProduct::where('deleted', '=', 0)
                            ->orderBy('date_added', 'desc')
                            ->limit(12)
                            ->get();
        $women = GroupProduct::where('deleted', '=', 0)
                            ->where('type', 1)
                        ->orderBy('date_added', 'desc')
                        ->limit(12)
                        ->get();

        $men = GroupProduct::where('deleted', '=', 0)
                ->where('type', 2)
                ->orderBy('date_added', 'desc')
                ->limit(12)
                ->get();
        $home = true;

        return view("index", compact('home', 'new', 'women', 'men'));
    }

    public function product(){
        $shop = true;

        $product = GroupProduct::where('deleted', '=', 0)->inRanDomOrder()->get();//->paginate(12);
        return view("product", compact("shop", 'product'));
    }

    public function detail($id){

        $product = GroupProduct::where('group_code', $id)->get()->first();
        return view("detail", compact("id", 'product'));
    }

    public function cart(){

        return view('cart');
    }

    public function order(Request $request){

        $orders = Order::where('id_customer', $request->session()->get("idCustomer"))->orderBy('order_date', 'desc')->paginate(3);
        return view('order', compact('orders'));
    }

    public function search(Request $request){

        $key = $request->get('k');
        $product = GroupProduct::where("deleted", 0)
                                ->whereRaw("(lower(group_code) like lower('%".$key."%') or lower(group_name) like lower('%".$key."%'))")
                                ->paginate(12);
        return view('search', compact('product', 'key'));
    }

    public function category($type, $category = null, Request $request){
        $typeID = ProductType::whereRaw("lower(type_code) like lower('$type')")->get()->first()->id;
        $filterQuery = null;
        $orderQuery = null;
        if($request->get('order')){
            $orderBy = $request->get('order');
            switch ($orderBy) {
                case 'price':
                    $orderQuery = "price";
                    break;
                case 'pricedesc':
                    $orderQuery = "price desc";
                    break;
                case 'newest':
                    $orderQuery = "date_added desc";
                    break;
            }
        }
        if($request->get('filterprice')){
            $filter = $request->get('filterprice');
            switch ($filter) {
                case '100':
                    $filterQuery = "price <= '100,000₫'";
                    break;
                case '300':
                    $filterQuery = "(price > '100,000₫' and price <= '300,000₫')";
                    break;
                case '500':
                    $filterQuery = "(price > '300,000₫' and price <= '500,000₫')";
                    break;
                case '1000':
                    $filterQuery = "(price > '500,000₫' and price <= '1,000,000₫')";
                    break;
                case 'max':
                    $filterQuery = "(price > '1,000,000₫')";
                    break;
            }
        }

        $product = null;
        if($category){
            $categoryID = Category::where('category_code', $category)->get();
            if($categoryID->count() > 0)
                $categoryID = $categoryID->first()->id;
                $product = GroupProduct::where("type", $typeID)
                                        ->where("id_category",$categoryID)
                                        ->where("deleted", 0);

                                        // ->get();
        }
        else $product = GroupProduct::where("type", $typeID)->where("deleted", 0);
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
