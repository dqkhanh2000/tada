<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Voucher;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function create(Request $request)
    {
        $voucher = Voucher::where('Code', $request->voucher)->get()->first();
        $idCustomer = $request->session()->get('idCustomer');
        $total = 0;
        $cart = Cart::where("id_customer", $idCustomer)->get();
        foreach ($cart as $cartItem){
            $cartProduct = $cartItem->product()->get()->first();
            $money = str_replace('₫', '', str_replace(',', '', $cartProduct->getGroup()->price));
            $total += ((int)$money)*$cartItem->quantity;
        }

        $order = new Order;
        $order->id_customer = $idCustomer;
        $order->total = $total;
        if($voucher){
            $order->total = ($total*$voucher->Value/100);
            $voucher->quantity_used = $voucher->quantity_used - 1;
            $voucher->save();
        }
        $order->address = $request->street . " " . $request->commune . " " . $request->district . " " .$request->city;
        if($order->save()){
            OrderDetailController::create($idCustomer, $order->id);
            (new CartController)->dropByCheckout($idCustomer);
            return url()->route('order');
        }
    }

}
