<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Customer;
use App\GroupProduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function getCartByCustomer($idCustomer)
    {
        return Cart::where("id_customer", "=", $idCustomer)->get();
    }

    public function create(Request $request)
    {
        $id_product = $request->productID;
        $idCustomer = $request->idCustomer;
        $count = null;
        if($idCustomer==null || $idCustomer == "null"){
            $count = Cart::where([["id_product", '=', $id_product], ["id_session", "=", $request->session()->getId()]])->get();
        }
        else
            $count = Cart::where([["id_product", '=', $id_product], ["id_customer", "=", $idCustomer]])->get();
        $cart = null;
       if( $count->count() > 0){
            $cart = $count->first();
            $cart->quantity = $count->first()->quantity+$request->quantity;
       }
       else {
           $cart = new Cart;
           $cart->quantity = $request->quantity;
        }
        $cart->id_product = $id_product;
        if(!($idCustomer==null || $idCustomer == "null"))
            $cart->id_customer = $idCustomer;
        $cart->id_session = $request->session()->getId();
       if($cart->save()) return "ok";

    }

    public function update(Request $request)
    {

        $data = $request->all();
        foreach($data as $key => $value){
            $cart = Cart::find($value['idCart']);
            if($value['quantity'] == 0){
                $this->drop($cart);
            }
            else{
                $cart->quantity = $value['quantity'];
                $cart->save();
            }
        }
        return 'ok';
    }

    public function drop(Cart $cart)
    {
        return $cart->delete();
    }

    public function dropByCheckout($idCustomer){
        $carts = $this->getCartByCustomer($idCustomer);
        foreach($carts as $key => $value){
            $this->drop($value);
        }
    }

    public function calTotal(){
        $carts = $this->getCartByCustomer(Session::get('idCustomer'));
        $sum = 0;
        foreach($carts as $key => $value){
            $price = $value->product()->get()->first()->getGroup()->price;
            $price = str_replace(',' , '', $price);
            $price = str_replace('₫' , '', $price);
            $sum += ((int)$price)*$value->quantity;
        }
        return $sum;
    }
}
