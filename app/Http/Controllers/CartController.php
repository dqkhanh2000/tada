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
        return Cart::where("CustomerID", "=", $idCustomer)->get();
    }

    public function create(Request $request)
    {
        $productID = $request->productID;
        $idCustomer = $request->idCustomer;
        $count = null;
        if($idCustomer)
            $count = Cart::where([["ProductID", '=', $productID], ["CustomerID", "=", $idCustomer]])->get();
        else
            $count = Cart::where([["ProductID", '=', $productID], ["SessionID", "=", $request->session()->getId()]])->get();
        $cart = null;
       if( $count->count() > 0){
            $cart = $count->first();
            $cart->Quantity = $count->first()->Quantity+$request->quantity;
       }
       else {
           $cart = new Cart;
           $cart->Quantity = $request->quantity;
        }
        $cart->ProductID = $productID;
        if($idCustomer)
            $cart->CustomerID = $idCustomer;
        $cart->SessionID = $request->session()->getId();
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
                $cart->Quantity = $value['quantity'];
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
            $price = $value->product()->get()->first()->getGroup()->Price;
            $price = str_replace(',' , '', $price);
            $price = str_replace('₫' , '', $price);
            $sum += ((int)$price)*$value->Quantity;
        }
        return $sum;
    }
}
