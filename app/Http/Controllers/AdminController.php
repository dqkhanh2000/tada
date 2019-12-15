<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\GroupProduct;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\ProductByColor;
use App\ProductImage;
use App\Voucher;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $order = Order::where('Status', 'Success')->get();
        $orderDetail = OrderDetail::all();
        $customer = Customer::all();
        return view('admin.dashboard', compact('order', 'orderDetail', 'customer'));
    }

    public function getReport(Request $request) {
        $total = [];
        $order = [];
        $view = [];
        $orderDB = null;
        $viewDB = NULL;
        $number = 0;
        $filter = '';
        if ($request->filter === 'month') {
            $filter = 'MONTH';
            $number = 12;
        }
        else{
            $filter = 'DAY';
            $number = 31;
        }
        $orderDB = DB::select(DB::raw('SELECT '.$filter.'(OrderDate) as filters, COUNT(OrderDate) as quantity, SUM(Total) as total, SUM(SubTotal) as sub
        From `orders` Where YEAR(OrderDate) = YEAR(CURRENT_TIMESTAMP) group By filters'));

        $viewDB = DB::select(DB::raw('SELECT '.$filter.'(`Date`) as filters, CountView as quantity
        From `views` Where YEAR(`Date`) = YEAR(CURRENT_TIMESTAMP)'));

        $indexOrder = 0;
        $indexView = 0;
        for($i = 1; $i <= $number; $i++){
            if(sizeof($orderDB) > 0 && $orderDB[$indexOrder]->filters === $i){
                $tmp = ($orderDB[$indexOrder]->total - $orderDB[$indexOrder]->sub);
                array_push($order, $orderDB[$indexOrder]->quantity);
                array_push($total, $tmp);
                $indexOrder++;
            }
            else{
                array_push($order, 0);
                array_push($total, 0);
            }

            if (sizeof($viewDB) > 0 && $viewDB[$indexView]->filters === $i) {
                array_push($view, $viewDB[$indexView]->quantity);
                $indexView++;
            }
            else array_push($view, 0);
        }
        return ['view' => $view, 'order' => $order, 'total' => $total];
    }
// function for product
    public function product(Request $request){
        if($request->method() == 'GET'){
            $category = Category::all();
            $groupProducts = GroupProduct::where('Deleted', '=', 0)->get();
            return view('admin.product', compact('groupProducts', 'category'));
        }
        if($request->method() == 'POST'){
            $groupProduct = GroupProduct::find($request->productid);
            $groupProduct->Deleted = 1;
            if($groupProduct->save()){
                return redirect($request->fullUrl());
            }
        }
    }

    public function editProduct(Request $request, $id = null){
        if ($request->method() == 'GET') {
            $groupProduct = GroupProduct::where('GroupNameNoVN', '=', $id)->get()->first();
            $category = Category::all();
            return view('admin.editproduct', compact('groupProduct', 'category'));
        }
        else{
            $group = GroupProduct::where('GroupNameNoVN', '=' , $request->code)->get()->first();
            $group->GroupName = $request->name;
            $group->Price = number_format($request->price).'₫';
            $group->Description = $request->description;
            $group->Sale = $request->sale;
            $path = '';
            if($request->type == 'Men') $path = '/products/men/'.$request->code;
            else if($request->type == 'Women') $path = '/products/women'.$request->code;

            //change color info
            foreach($group->productByColor()->get() as $color){
                $postColor = $color->Color;
                if($request->$postColor != $color->Color){
                    $color->Color = $request->$postColor;
                    $color->save();
                }
                $imgname = 'img'.$color->Color;
                if($request->$imgname[0]){
                    foreach ($request->$imgname as $key => $value) {
                        $fileName = $request->type.'_'.$request->$postColor.'__'.md5($value).'.'.$value->getClientOriginalExtension();
                        $value->storeAs($path, $fileName);
                        $image = new ProductImage;
                        $image->Path = $path.'/'.$fileName;
                        $image->ProductByColorID = $color->ProductByColorID;
                        $image->save();
                    }
                }
            }

            //new color
            for($i = 1; $i <= $request->numcolor; $i++){
                $color = 'color'.$i;
                $imgs = 'imgcolor'.$i;
                $photo = $request->$color;
                $product = new ProductByColor;
                $product->Color = $request->$color;
                $product->GroupProductID = $group->GroupProductID;
                $saved = false;
                foreach ($request->$imgs as $key => $value) {
                    $fileName = $request->type.'_'.$request->$color.'__'.(intval($key)+1).'__'.md5($value).'.'.$value->getClientOriginalExtension();
                    $value->storeAs($path, $fileName);
                    if(!$saved){
                        $product->SmallImage = $path.'/'.$fileName;
                        $product->save();
                        $saved = true;
                    }
                    $image = new ProductImage;
                    $image->Path = $path.'/'.$fileName;
                    $image->ProductByColorID = $product->ProductByColorID;
                    $image->save();
                }
            }

            if($request->avatar){
                $avatarName = $request->type.'_'.md5($request->avatar).'.'.$request->avatar->getClientOriginalExtension();
                $request->avatar->storeAs($path, $avatarName);
                $tmp = $group->productByColor()->get()->first();
                $tmp->SmallImage = $path.'/'.$avatarName;
                $tmp->save();
            }
            $group->save();

            return redirect(route('admin.product'));
        }
    }

    public function deleteImage(Request $request){
        $img = ProductImage::find($request->idimage);
        if($img->delete()){
            return redirect($request->header()['referer'][0]);
        }
    }

    public function createProduct(Request $request){
        if ($request->method() == 'GET') {
            $category = Category::all();
            return view('admin.createproduct', compact('category'));
        }
        else{
            //insert new group product
            $group = new GroupProduct;
            $group->GroupName = $request->name;
            $group->GroupNameNoVN = $request->code;
            $group->Price = number_format($request->price).'₫';
            $group->Description = $request->description;
            $group->Sale = $request->sale;
            $group->CategoryID = Category::where('CategoryName', '=', $request->category)->get()->first()->CategoryID;
            $group->Type = $request->type;
            $group->save();
            //create path to save image
            $path = '';
            if($request->type == 'Men') $path = '/products/men/'.$request->code;
            else if($request->type == 'Women') $path = '/products/women'.$request->code;
            for($i = 1; $i <= $request->numcolor; $i++){
                $color = 'color'.$i;
                $imgs = 'imgcolor'.$i;
                $size = 'size'.$i;
                $quantity = 'quantity'.$i;

                //insert productbycolor and save image
                $productByColor = new ProductByColor;
                $productByColor->Color = $request->$color;
                $productByColor->GroupProductID = $group->GroupProductID;
                $saved = false;
                foreach ($request->$imgs as $key => $value) {
                    $fileName = $request->type.'_'.$request->$color.'__'.(intval($key)+1).'__'.md5($value).'.'.$value->getClientOriginalExtension();
                    $value->storeAs($path, $fileName);
                    if(!$saved){
                        $productByColor->SmallImage = $path.'/'.$fileName;
                        $productByColor->save();
                        $saved = true;
                    }
                    $image = new ProductImage;
                    $image->Path = $path.'/'.$fileName;
                    $image->ProductByColorID = $productByColor->ProductByColorID;
                    $image->save();
                }

                //insert product
                for($j = 0; $j < sizeof($request->$size); $j++){
                    $product = new Product;
                    $product->Size = $request->$size[$j];
                    $product->QuantityStorage = $request->$quantity[$j];
                    $product->ProductByColorID = $productByColor->ProductByColorID;
                    $product->save();
                }
            }
            if($request->avatar){
                $avatarName = $request->type.'_'.md5($request->avatar).'.'.$request->avatar->getClientOriginalExtension();
                $request->avatar->storeAs($path, $avatarName);
                $tmp = $group->productByColor()->get()->first();
                $tmp->SmallImage = $path.'/'.$avatarName;
                $tmp->save();
            }
            $group->save();
            return redirect(route('admin.product'));
        }
    }
// function for order

    public function order()
    {
        $orders = Order::all();
        return view('admin.order', compact('orders'));
    }

    public function orderDetail($id, Request $request){
        $order = Order::find($id);
        return view('admin.orderdetail', compact('order'));
    }

    public function customer(){
        $customers = Customer::all();
        return view('admin.customer', compact('customers'));
    }

    public function voucher(Request $request){
        if($request->method() == 'GET'){
            $vouchers = Voucher::all();
            return view('admin.voucher', compact('vouchers'));
        }
        else if($request->method() =='POST'){
            $time = Carbon::parse($request->endtime);
            $voucher = new Voucher;
            $voucher->Code = $request->code;
            $voucher->Event = $request->event;
            $voucher->EndDate = $time->format('Y-m-d H:i:s');
            $voucher->Value = $request->value;
            $voucher->Quantity = $request->quantity;
            if($voucher->save())
            return redirect()->route('admin.voucher');
        }
    }

}
