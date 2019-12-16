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
        $cart = Cart::where("CustomerID", $idCustomer)->get();
        foreach ($cart as $cartItem){
            $cartProduct = $cartItem->product()->get()->first();
            $money = str_replace('₫', '', str_replace(',', '', $cartProduct->getGroup()->Price));
            $total += ((int)$money)*$cartItem->Quantity;
        }

        $order = new Order;
        $order->CustomerID = $idCustomer;
        if($voucher){
            $order->SubTotal = ($total*$voucher->Value/100);
            $voucher->QuantityUsed = $voucher->QuantityUsed - 1;
            $voucher->save();
        }
        $order->Total = $total;
        $order->Address = $request->street . " " . $request->commune . " " . $request->district . " " .$request->city;
        if($order->save()){
            OrderDetailController::create($idCustomer, $order->OrderID);
            (new CartController)->dropByCheckout($idCustomer);
            return url()->route('order');
        }
    }

}
