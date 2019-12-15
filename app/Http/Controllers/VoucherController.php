<?php

namespace App\Http\Controllers;

use App\Voucher;
use DateTime;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $voucher = Voucher::where('Code', $request->voucher)->get();
        $totalCart = (new CartController)->calTotal();
        if($voucher->count() > 0){
            $voucher = $voucher->first();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = date("Y-m-d H:i:s");
            if($voucher->Status === "Active" && $now < $voucher->EndDate && $voucher->Quantity - $voucher->QuantityUsed > 0){
                return $voucher->Value;
            }
            else return ["false" => "Mã giảm giá không còn khả dụng"];
        }
        else return ["false" => "Không tìm thấy mã giảm giá này!"];

    }
}
